    USE clothes_match;                                                                                           
                                                                                                                 
    -- --------------------------------------------------------                                                  
    -- 1. Saisons                                                                                                
    -- --------------------------------------------------------                                                  
    INSERT INTO seasons (id, name, avg_temperature, icon_url) VALUES                                             
    (1, 'Printemps', 20, '/icons/spring.svg'),                                                                      
    (2, 'Été', 30, '/icons/summer.svg'),                                                                      
    (3, 'Automne', 15, '/icons/autumn.svg'),                                                                      
    (4, 'Hiver',  5, '/icons/winter.svg');                                                                                                                               
                                                                                                                 
    -- --------------------------------------------------------                                                  
    -- 2. Utilisateurs                                                                                           
    -- (password = "password123" hashé via bcrypt)                                                               
    -- --------------------------------------------------------                                                  
    INSERT INTO users (id, name, email, password, last_color_harmony_importance, last_season_harmony_importance) 
  VALUES                                                                                                         
    (1, 'Alice Martin', 'alice.martin@example.com', '$2y$12$e8Yk1m4gA27YnIuN2xZ/g.wZkQ52kC76F8M.                 
  G/Jk2X7x9wL40mYqK', 0.75, 0.25),                                                                               
    (2, 'Bob Dupont',   'bob.dupont@example.com',   '$2y$12$e8Yk1m4gA27YnIuN2xZ/g.wZkQ52kC76F8M.                 
  G/Jk2X7x9wL40mYqK', 0.15, 0.85),                                                                               
    (3, 'Chloé Viret',  'chloe.viret@example.com',  '$2y$12$e8Yk1m4gA27YnIuN2xZ/g.wZkQ52kC76F8M.
  G/Jk2X7x9wL40mYqK', 0.60, 0.40);
  
    -- --------------------------------------------------------
    -- 3. Vêtements (clothes)
    -- Catégories : 'top', 'bottom', 'shoes', 'jacket', 'accessory'
    -- Teinte (hue) : [0-360], Saturation / Luminosité (brightness) : [0-1]
    -- --------------------------------------------------------
    INSERT INTO clothes (id, img_url, category, season_id, hue, saturation, brightness, user_rate, user_id)      
  VALUES
    -- Hauts (tops)
    (1,  '/uploads/white_tshirt.jpg',   'top',       2,   0.0, 0.00, 0.95, 5, 1),
    (2,  '/uploads/navy_shirt.jpg',     'top',       1, 215.0, 0.65, 0.35, 4, 1),
    (3,  '/uploads/beige_knit.jpg',     'top',       4,  38.0, 0.25, 0.82, 5, 1),
    (4,  '/uploads/black_hoodie.jpg',   'top',       3,   0.0, 0.00, 0.12, 4, 2),
  
    -- Bas (bottoms)
    (5,  '/uploads/raw_denim_jeans.jpg','bottom',    3, 220.0, 0.55, 0.28, 5, 1),
    (6,  '/uploads/beige_chino.jpg',    'bottom',    1,  42.0, 0.32, 0.78, 4, 1),
    (7,  '/uploads/black_trousers.jpg', 'bottom',    4,   0.0, 0.00, 0.15, 4, 2),
    (8,  '/uploads/linen_shorts.jpg',   'bottom',    2,  48.0, 0.18, 0.88, 3, 2),
  
    -- Chaussures (shoes)
    (9,  '/uploads/white_sneakers.jpg', 'shoes',     2,   0.0, 0.00, 0.98, 5, 1),
    (10, '/uploads/brown_boots.jpg',    'shoes',     4,  28.0, 0.58, 0.32, 4, 1),
    (11, '/uploads/black_derbies.jpg',  'shoes',     3,   0.0, 0.00, 0.10, 4, 2),
  
    -- Vestes / Manteaux (jackets)
    (12, '/uploads/denim_jacket.jpg',   'jacket',    1, 210.0, 0.45, 0.42, 4, 1),
    (13, '/uploads/wool_coat.jpg',      'jacket',    4, 205.0, 0.12, 0.22, 5, 1),
    (14, '/uploads/windbreaker.jpg',    'jacket',    3, 140.0, 0.40, 0.35, 3, 2),
  
    -- Accessoires (accessories)
    (15, '/uploads/leather_belt.jpg',   'accessory', 1,  30.0, 0.60, 0.25, 4, 1),
    (16, '/uploads/grey_scarf.jpg',     'accessory', 4,   0.0, 0.00, 0.60, 5, 1),
    (17, '/uploads/beanie.jpg',         'accessory', 4, 350.0, 0.45, 0.30, 4, 2);
  
    -- --------------------------------------------------------
    -- 4. Tenues générées (results)
    -- --------------------------------------------------------
    INSERT INTO results (id, id_top, id_bottom, id_shoes, id_jacket, id_accessory, timestamp) VALUES             
    (1, 1, 5,  9, 12,   15, '2026-04-12 10:15:00'),
    (2, 3, 5, 10, 13,   16, '2026-01-20 08:45:00'),
    (3, 2, 6,  9, NULL, 15, '2026-05-02 18:20:00'),
    (4, 4, 7, 11, 14,   17, '2026-10-10 14:05:00');
