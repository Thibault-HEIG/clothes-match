# Outfit Generator: Formula Cascade (v1)

Read top-down. Each level uses quantities defined in the level below it, until only input features and parameters remain.

```
L1  Selection probability      P(c)
L2  Candidate score            score(c)
L3  Feasible candidates        K(X)
L4  Base fit                   F(c)  = w·C + (1-w)·S
L5  Color score                C(c)   (aggregation over the context)
L6  Pair score                 p_ci   = a_h·hue + a_s·sat + a_v·bri
L7  Sub-scores                 hue_ci, sat_ci, bri_ci
L8  Relevance                  r_i (hue), q_i (saturation)
L9  Raw hue match              H(d), circular distance d
L10 Season score               S(c)
L11 Wishes                     season filter, color wish
L12 Generation loop            seed, order, restarts
```

---

## Notation

| Symbol | Meaning |
|---|---|
| $X$ | Context: items already chosen in this outfit |
| $c$ | Candidate item being scored |
| $i, j$ | Items of the context |
| $\kappa_i$ | Category of item $i$ (top, bottom, shoes, jacket, accessory) |
| $h_i, s_i, v_i$ | Hue, saturation, brightness of item $i$, all in $[0,1]$ |
| $t_i$ | Season (temperature) of item $i$, in $[0,1]$ |
| $u_i$ | User rate of item $i$, in $\{1,\dots,5\}$ stars |

---

## L1. Next-item selection

$$
P(c) \;=\; \frac{\exp\big(\mathrm{score}(c)/T\big)}{\sum_{c' \in \mathcal{K}(X)\,\cup\,\{\varnothing\}} \exp\big(\mathrm{score}(c')/T\big)}
$$

The next item is sampled from $P$. $\varnothing$ (NULL) is only a candidate for optional categories (jacket, accessory).

| Symbol | Meaning | Value |
|---|---|---|
| $T$ | Temperature. Low = near-deterministic, high = more random | $0.3$ |
| $\mathcal{K}(X)$ | Feasible candidates of the current category (see L3) | |
| $\varnothing$ | NULL candidate | |

---

## L2. Candidate score

$$
\mathrm{score}(c) \;=\; \frac{u_c}{5}\;\cdot\;F_{\text{wish}}(c)
\qquad\qquad
\mathrm{score}(\varnothing) \;=\; b_\varnothing
$$

The user rate is a multiplicative factor (stars divided by 5, so it stays in $[0.2, 1]$).

$$
F_{\text{wish}}(c) \;=\; (1-\lambda)\,F(c) \;+\; \lambda\,W_h(c)
$$

With no color wish set, $\lambda = 0$ and $F_{\text{wish}} = F$.

| Symbol | Meaning | Value |
|---|---|---|
| $b_\varnothing$ | Fixed mediocre score of NULL. It wins when the real candidates score low | $0.4$ |
| $\lambda$ | Fixed internal weight of the color wish (0 if no wish) | to tune |
| $F(c)$ | Base fit: color harmony and season harmony (L4) | |
| $W_h(c)$ | Color wish match (L11) | |

---

## L3. Feasible candidates (hard constraints)

$$
\mathcal{K}(X) \;=\; \Big\{\, c \in \text{category} \;:\;
\Delta(c,X) \le \Delta_{\max}
\;\wedge\;
p_{\min}(c,X) > \theta
\;\wedge\;
|t_c - t^\ast| \le \delta_t \,\Big\}
$$

Infeasible candidates are removed before scoring. They are not scored 0.

| Symbol | Meaning | Value |
|---|---|---|
| $\Delta(c,X)$ | Season range of the outfit with $c$ added (L10) | |
| $\Delta_{\max}$ | Maximum allowed season range | $0.75$ |
| $p_{\min}(c,X)$ | Worst pair score between $c$ and the context (L5) | |
| $\theta$ | Minimum acceptable pair score (clash threshold) | $0.2$ |
| $t^\ast$ | Season wish, target temperature in $[0,1]$ (L11). Ignore this condition if no wish | |
| $\delta_t$ | Maximum distance to the season wish | $0.5$ |

---

## L4. Base fit

$$
F(c) \;=\; w\cdot C(c,X) \;+\; (1-w)\cdot S(c,X)
$$

| Symbol | Meaning | Value |
|---|---|---|
| $w$ | User slider in $[0,1]$: $0$ = only season harmony matters, $1$ = only color harmony matters | user input |
| $C$ | Color score (L5) | |
| $S$ | Season score (L10) | |

If the UI has two independent importances $w_c, w_s$: use $w = w_c / (w_c + w_s)$.

---

## L5. Color score of a candidate against the context

The candidate is scored against **each** chosen item. The context is never averaged into one color.

$$
p_{ci}\;\;\text{for each } i \in X
\qquad
\bar p \;=\; \frac{\sum_{i\in X} \omega(\kappa_c,\kappa_i)\; p_{ci}}{\sum_{i\in X} \omega(\kappa_c,\kappa_i)}
$$

$$
p_{\max} = \max_{i\in X} p_{ci}
\qquad
p_{\min} = \min_{i\in X} p_{ci}
$$

$$
C(c,X) \;=\; \bar p \;+\; \gamma\,\big(p_{\max} - \bar p\big)
\qquad (\,C = 1 \text{ if } X = \varnothing\,)
$$

The clash rule ($p_{\min} > \theta$) is applied in L3. The term $\gamma(p_{\max}-\bar p)$ is a bonus for one very good fit.

| Symbol | Meaning | Value |
|---|---|---|
| $\bar p$ | Category-weighted mean of the pair scores | |
| $\omega(\kappa_c,\kappa_i)$ | Importance of the category pair (e.g. top-bottom high, accessory-anything low) | to confirm |
| $\gamma$ | Strength of the best-pair bonus. $\gamma = 1$ gives $C = p_{\max}$ | $0.2$ (suggested) |

---

## L6. Pair score (two items)

$$
p_{ci} \;=\; a_h\cdot \mathrm{hue}_{ci} \;+\; a_s\cdot \mathrm{sat}_{ci} \;+\; a_v\cdot \mathrm{bri}_{ci}
\qquad a_h + a_s + a_v = 1
$$

| Symbol | Meaning | Value |
|---|---|---|
| $a_h, a_s, a_v$ | Internal weights of hue, saturation, brightness | $0.5,\; 0.2,\; 0.3$ |

---

## L7. Sub-scores

**Hue** (neutral-aware, $H$ defined in L9):

$$
\mathrm{hue}_{ci} \;=\; r_{ci}\; H\big(d(h_c,h_i)\big) \;+\; (1 - r_{ci})\;\nu
$$

**Saturation** (neutral-aware, using the brightness-only relevance):

$$
\mathrm{sat}_{ci} \;=\; q_{ci}\,\big(1 - |s_c - s_i|\big) \;+\; (1 - q_{ci})\;\nu
$$

**Brightness contrast** (bigger contrast is better, capped so black/white is not better than a 0.5 contrast):

$$
\mathrm{bri}_{ci} \;=\; 2\,\min\big(|v_c - v_i|,\; 0.5\big)
$$

| Symbol | Meaning | Value |
|---|---|---|
| $\nu$ | Neutral value: score when hue (or saturation) is meaningless. Must stay below 1 | $0.6$ |
| $r_{ci}$ | Hue relevance of the pair (L8) | |
| $q_{ci}$ | Saturation relevance of the pair (L8) | |
| $d(h_c,h_i)$ | Circular hue distance (L9) | |

---

## L8. Relevance (is the hue visible?)

Hue is noise for dull colors: low saturation (white, grey, beige) or low brightness (black, very dark colors). A bright, saturated pastel keeps its hue.

$$
r_i \;=\; \min\!\Big(1,\frac{s_i}{s_0}\Big)\cdot\min\!\Big(1,\frac{v_i}{v_0}\Big)
\qquad
r_{ci} \;=\; \min(r_c, r_i)
$$

$$
q_i \;=\; \min\!\Big(1,\frac{v_i}{v_0}\Big)
\qquad
q_{ci} \;=\; \min(q_c, q_i)
$$

$q$ uses brightness only because a white or grey has a *meaningful* saturation of about 0. Black is the real noise case.

| Symbol | Meaning | Value |
|---|---|---|
| $r_i$ | Hue relevance of one item. $0$ = neutral, $1$ = hue fully visible | computed |
| $q_i$ | Saturation relevance of one item | computed |
| $s_0$ | Saturation above which hue is fully visible | $0.25$ |
| $v_0$ | Brightness above which hue is fully visible | $0.20$ |

A pair is colorful only if **both** items are (hence the $\min$). The blend is smooth, so a grey at $s = 0.09$ and one at $s = 0.11$ behave almost the same.

---

## L9. Raw hue match and circular distance

Hue is a circle ($0 \equiv 1$):

$$
d(h_a,h_b) \;=\; \min\big(|h_a - h_b|,\; 1 - |h_a - h_b|\big)
\qquad d \in [0, 0.5]
$$

$$
H(d) \;=\;
\begin{cases}
1 - 0.1\,\dfrac{d}{\varepsilon} & \text{if } d < \varepsilon \quad\text{(same hue, } [0.9,\,1]\text{)}\\[2mm]
1.8\,d & \text{otherwise} \quad\text{(linear, } [0,\,0.9]\text{; } 0.9 \text{ at the complementary hue)}
\end{cases}
$$

| Symbol | Meaning | Value |
|---|---|---|
| $\varepsilon$ | Half-width of the "same hue" zone | $0.02$ |

Reference values:

| $d$ | $0$ | $0.01$ | $0.03$ | $0.25$ | $0.5$ |
|---|---|---|---|---|---|
| $H(d)$ | $1.00$ | $0.95$ | $0.054$ | $0.45$ | $0.90$ |

The drop between $d = 0.02$ ($0.9$) and $d = 0.03$ ($0.054$) is a cliff by design. Two slightly different blues score as a near-worst pair.

---

## L10. Season score

$$
\Delta(c,X) \;=\; \max_{j \in X\cup\{c\}} t_j \;-\; \min_{j \in X\cup\{c\}} t_j
$$

$$
S(c,X) \;=\; \frac{\Delta_{\max} - \Delta(c,X)}{\Delta_{\max}}
$$

Candidates with $\Delta > \Delta_{\max}$ are already removed in L3, so $S \in [0,1]$. For $X = \varnothing$: $\Delta = 0$, $S = 1$.

---

## L11. Wishes

**Season wish.** The user gives a temperature $T_{^\circ C} \in [0, 35]$:

$$
t^\ast \;=\; \mathrm{clip}\!\Big(\frac{T_{^\circ C}}{35},\,0,\,1\Big)
$$

Used only as the hard filter in L3.

**Color wish.** The user gives a target hue $h^\ast$. Reuse the hue machinery, with neutrals getting the neutral value:

$$
W_h(c) \;=\; r_c\; H\big(d(h_c,h^\ast)\big) \;+\; (1-r_c)\;\nu
$$

Used in L2 with the fixed weight $\lambda$.

| Symbol | Meaning |
|---|---|
| $t^\ast$ | Target temperature in $[0,1]$ |
| $h^\ast$ | Target hue in $[0,1]$ |

---

## L12. Generation loop

1. **Seed.** Only required categories (top, bottom, shoes). Sample with
   $$P_0(i) \;\propto\; u_i \cdot W_h(i)$$
   (drop $W_h$ if no color wish; apply the season wish filter if set).
2. **Order.** top, bottom, shoes, jacket, accessory. Skip the seed's category.
3. **For each category:** build $\mathcal{K}(X)$, add $\varnothing$ if optional, sample with L1, append to $X$.
4. **Dead end** (a required category has $\mathcal{K}(X) = \varnothing$): restart with a new seed.
5. **After $N$ failed restarts** (e.g. 20): pick a fully random item from that category.

---

## Inputs

| Input | Symbol | Range |
|---|---|---|
| Category | $\kappa$ | top, bottom, shoes, jacket, accessory |
| Hue | $h$ | $[0,1]$, circular |
| Saturation | $s$ | $[0,1]$ |
| Brightness | $v$ | $[0,1]$ |
| Season (temperature) | $t$ | $[0,1]$ |
| User rate | $u$ | $1$ to $5$ stars |
| Color/season importance | $w$ | $[0,1]$ |
| Color wish | $h^\ast$ | $[0,1]$ (optional) |
| Season wish | $T_{^\circ C}$ | $[0, 35]$ (optional) |

## All parameters

| Parameter | Value | Level |
|---|---|---|
| $T$ | $0.3$ | L1 |
| $b_\varnothing$ | $0.4$ | L2 |
| $\lambda$ | to tune | L2 |
| $\Delta_{\max}$ | $0.75$ | L3, L10 |
| $\theta$ | $0.2$ | L3 |
| $\delta_t$ | $0.5$ | L3 |
| $\gamma$ | $0.2$ (suggested) | L5 |
| $\omega(\kappa,\kappa')$ | to confirm | L5 |
| $a_h, a_s, a_v$ | $0.5, 0.2, 0.3$ | L6 |
| $\nu$ | $0.6$ | L7 |
| $s_0, v_0$ | $0.25, 0.20$ | L8 |
| $\varepsilon$ | $0.02$ | L9 |
| $N$ | $20$ | L12 |
