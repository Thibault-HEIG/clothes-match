# Outfit Generator: Algorithm Plan (v1)

---

## 1. Scope

**Goal:** generate a 3-5 item outfit from a wardrobe.

**Categories** (assumed): `top`, `bottom`, `shoes` are required. `jacket` and `accessory` may be `NULL`. That gives 3 to 5 items.

**User inputs (per generation):**

| Input | Type | Meaning |
| --- | --- | --- |
| `w_color` | [0,1] | How much color harmony matters |
| `w_season` | [0,1] | How much season harmony matters |
| `color_wish` | see Q4 | Desired color for the outfit |
| `season_wish` | see Q5 | Desired temperature for the outfit |

**Item features:** `category`, `hue`, `saturation`, `brightness` (all [0,1]), `season` ([0,1], temperature), `user_rate`.

---

## 2. Method

It is LLM-like in generation. Score against each previously selected items.

```python
# 0.2 Threshold to avoid clash
if min_score > 0.2:
	final_score = mean + (max_score - mean) # Bonus for a very good fit
else:
	final_score = 0
```

```
context = [seed]
for category in remaining categories (fixed order):
	   candidates = items in category that pass hard constraints
	   if category is optional: add NULL as a candidate
	   logit(c)   = score(c, context) / T
	   P(c)       = softmax(logit)
	   context   += sample(P)
```

- `T` (temperature): low = near-deterministic, high = more random. It gives variety for free.
- The context grows, so every candidate is scored against **all items already chosen**.

---

## 3. Color score

### 3.1 Hue distance (circular)

Hue 0 and 1 are the same color, so:

$$
distance = min(|h_a - h_b|, 1 - |h_a - h_b|)
$$

### 3.2 Raw hue match

Two narrow peaks: one at `d = 0` (same hue), one at `d = 0.5` (complementary).

```
1. if distance is below 0.02 -> inversed_linear_score [0.9,1]
2. if neutral -> 0.6
3. linear_score for distance [0,0.9]
```

### 3.3 Hue relevance and the neutral override

Hue is noise for dull colors. In HSB terms, hue is meaningless when:

- saturation is low
- brightness is low

But a bright, saturated pastel keeps a visible hue. That is your "lower left region" reasoning, and it is correct in HSB/HSV

**The idea**: irrelevant hue follows a `1/x`-type function.

```
# 0 = neutral, 1 = hue fully visible
r_i = min(1, sat_i / s0) * min(1, bri_i / b0)

# a pair is only "colorful" if both items are
r_ij = min(r_i, r_j)

# 0.6 = arbitrary neutral value
hue_score_ij = r_ij * hue_raw + (1 - r_ij) * 0.6
```

Starting values: `s0 = 0.25`, `b0 = 0.20`.

- Smooth blend, no hard cutoff: a grey with saturation 0.09 and one with 0.11 must not behave differently.
- `0.6` must stay **below** an exact hue match (1.0), or neutrals will always beat carefully matched colors.

### 3.4 Saturation score

```
sat_raw_ij = 1 - |sat_i - sat_j|
sat_score_ij = r_ij_sat * sat_raw + (1 - r_ij_sat) * 0.6
```

**⚠️** Without an override here, black + red is punished for "different saturation". Apply the same neutral logic. 

- Use only the brightness part (`min(1, bri/b0)`), because a white or grey has a true saturation of ~0 that is *meaningful*, unlike its hue. Black is the real "noise" case.

### 3.5 Brightness contrast

```
bri_score_ij = min(|bri_i - bri_j|, 0.5) * 2
```

Bigger contrast is better. Side effect: two dark items (black jeans + navy jacket) score low. That follows your rule, but check it on real outfits. Max is 0.5 so black and white items are not better.

### 3.6 Combining into a pair score

```
c_ij = a_h * hue_score + a_s * sat_score + a_b * bri_score
(a_h + a_s + a_b = 1)
```

Starting values: `a_h = 0.5`, `a_s = 0.2`, `a_b = 0.3`. These are **internal constants**, not user-facing.

### 3.7 Color score of a candidate against the context

```
C(c, context) = Σ_i (cat_c, cat_i) * c(c, i)  /  Σ_i (cat_c, cat_i)
```

For the first item (empty context), `C = 1` (nothing to compare).

---

## 4. Season score

### 4.1 Score

```
if range > 0.75:  reject candidate (hard)
S = (0.75 - range) / 0.75
```

`0.75 - range` alone is not in [0,1]. Divide by 0.75 so `S` stays in [0,1].

Note that `S = 0` exactly at the rejection threshold, so the hard reject only serves to *remove* those candidates from the softmax. It is not a separate rule.

For the current candidate, `range` is computed with the candidate added to the context.

---

## 5. User rate

`user_rate` (1-5 stars). Mulitply the final_score by it (divide stars if necessary)

**⚠️** Without a wear-count or recency penalty, top-rated items appear in every outfit. Parked for v2.

---

## 6. Combining scores (user weights)

`C` and `S` are both in [0,1]. `w_color` and `w_season` come from the user and create a weighted sum.

This is an input range going toward one or the other.

---

## 7. Wishes

### 7.1 Season wish

Wish = target temperature `t*` [0°C,35°C] to [0,1].

Hard filter if temperature distance is bigger than `0.50`.

### 7.2 Color wish

Wish = target hue `h*` [0,1].

Items get a bonus by circular distance to `h*`, scaled by hue relevance `r_i` (neutrals get a neutral value).

### 7.3 Wish strength

Fixed internal weight.

---

## 8. Sampling details

### 8.1 Seed

- Random item weighted by `user_rate` (and weighted by the color and season wish if set).
- Seed fromonly from required ones (`top`, `bottom`, `shoes`)

### 8.2 Category order

Fixed: `top` → `bottom` → `shoes` → `jacket` → `accessory`, skipping the seed's category. Most constraining first, optional last.

**⚠️** The seed and the order shape everything. To check for bias, test the same wardrobe with different orders.

### 8.3 NULL candidate

For `jacket` and `accessory`, `NULL` is a candidate with a fixed mediocre score (`0.4`). It is competitive when real items score low, and rarely chosen when they score high.

### 8.4 Dead ends

Season and `min_acceptable_score (0.2)` are hard constraints, so a category can end up with zero candidates.

1. Remove infeasible candidates *before* scoring.
2. If a required category is empty: restart with a new seed.
3. After `N` failed restarts (e.g. 20): pick a fully random item from the category.

### 8.5 Temperature

fixed `T` (e.g. 0.3) for v1.

---

## 9. Parameters to tune

| Parameter | Start | Role |
| --- | --- | --- |
| `s0`, `b0` | 0.25, 0.20 | Where hue becomes visible |
| neutral constant | 0.6 | Score of a neutral pair |
| `σ_same`, `σ_compl` | 0.03, 0.05 | Hue peak widths |
| `a_h`, `a_s`, `a_b` | 0.5, 0.2, 0.3 | Sub-score weights in the pair score |
| `min_acceptable_score` | 0.2 | Minimum acceptable score |
| `b_null` | 0.4 | NULL baseline |
| `β`, `ε` | 1.0, 0.05 | Rate influence |
| `T` | 0.3 | Randomness |

Too many constants is the main risk. Keep them in **one config object** so you can tune without touching the logic.

---

## 10. Validation

1. **Heatmap:** plot `c_ij` over the (hue_i, hue_j) grid for a fixed saturation/brightness. You should see two diagonals (same, complementary) and a flat 0.8 plateau for neutrals.
2. **Diversity check:** how often does the same item appear? If top-rated items dominate, adjust `β` or `T`.

---

## 11. Build order

1. Data model + fixture wardrobe (Q-season model first).
2. Color function + heatmap (fastest visible result).
3. Season function.
4. Sampler with seed, order, NULL, dead ends.
5. User weights and aggregation.
6. Wishes.
7. Tuning pass on real outfits.
