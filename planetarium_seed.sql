-- Seed data for planetarium and planetarium_facts
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE planetarium_facts;
TRUNCATE TABLE planetarium;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO planetarium (
  id, name, image, type, diameter, mass, distance, temperature, orbit_period,
  moons, gravity, day_length, atmosphere, composition, age, description,
  is_active, created_by
) VALUES
  (1, 'sun', 'assets/images/planets/sun.webp', 'Star', '1,391,000 km', '1.989e30 kg', '-', '5,500 C surface', '-', '0', '274 m/s2', '25-35 Earth days', 'Hydrogen and helium plasma', '73% hydrogen, 25% helium, trace elements', '4.6 billion years', 'Matahari adalah bintang pusat Tata Surya dan sumber energi utama bagi seluruh planet.', 1, NULL),
  (2, 'mercury', 'assets/images/planets/mercury.webp', 'Terrestrial planet', '4,879 km', '3.285e23 kg', '57.9 million km from Sun', '-173 C to 427 C', '88 Earth days', '0', '3.7 m/s2', '176 Earth days', 'Exosphere tipis', 'Besi dan silikat', '4.5 billion years', 'Mercury adalah planet terkecil dan terdekat dengan Matahari dengan permukaan penuh kawah.', 1, NULL),
  (3, 'venus', 'assets/images/planets/venus.webp', 'Terrestrial planet', '12,104 km', '4.867e24 kg', '108.2 million km from Sun', '462 C rata-rata', '225 Earth days', '0', '8.87 m/s2', '243 Earth days (retrograde)', '96% CO2 dengan awan asam sulfat', 'Batuan silikat', '4.5 billion years', 'Venus memiliki efek rumah kaca ekstrem yang membuatnya menjadi planet terpanas di Tata Surya.', 1, NULL),
  (4, 'earth', 'assets/images/planets/earth.webp', 'Terrestrial planet', '12,742 km', '5.972e24 kg', '149.6 million km from Sun', '-88 C to 58 C', '365.25 days', '1', '9.81 m/s2', '23h 56m', 'Nitrogen dan oksigen', 'Batuan silikat dan inti besi', '4.5 billion years', 'Bumi adalah satu-satunya planet yang diketahui mendukung kehidupan dengan air cair melimpah.', 1, NULL),
  (5, 'mars', 'assets/images/planets/mars.webp', 'Terrestrial planet', '6,779 km', '6.39e23 kg', '227.9 million km from Sun', '-125 C to 20 C', '687 days', '2', '3.71 m/s2', '24h 37m', 'CO2 tipis', 'Batuan vulkanik dan es air', '4.5 billion years', 'Mars adalah planet merah dengan gunung Olympus Mons dan kemungkinan air beku di kutub.', 1, NULL),
  (6, 'jupiter', 'assets/images/planets/jupiter.webp', 'Gas giant', '139,820 km', '1.898e27 kg', '778.5 million km from Sun', '-145 C awan atas', '11.86 years', '95+', '24.79 m/s2', '9h 56m', 'Hidrogen dan helium', 'Inti padat kecil, lapisan gas tebal', '4.5 billion years', 'Jupiter adalah planet terbesar dengan Bintik Merah Besar dan cincin tipis.', 1, NULL),
  (7, 'saturn', 'assets/images/planets/saturn.webp', 'Gas giant', '116,460 km', '5.683e26 kg', '1.43 billion km from Sun', '-178 C awan atas', '29.46 years', '146+', '10.44 m/s2', '10h 42m', 'Hidrogen dan helium', 'Inti batu es dengan lapisan gas', '4.5 billion years', 'Saturn terkenal dengan sistem cincin es yang luas dan ratusan satelit kecil.', 1, NULL),
  (8, 'uranus', 'assets/images/planets/uranus.webp', 'Ice giant', '50,724 km', '8.681e25 kg', '2.87 billion km from Sun', '-197 C awan atas', '84 years', '27', '8.69 m/s2', '17h 14m (axis tilt 98 deg)', 'Hidrogen, helium, metana', 'Inti batu es dengan lapisan es air-amonia', '4.5 billion years', 'Uranus berputar hampir di sisinya sehingga musimnya berlangsung puluhan tahun.', 1, NULL),
  (9, 'neptune', 'assets/images/planets/neptune.webp', 'Ice giant', '49,244 km', '1.024e26 kg', '4.5 billion km from Sun', '-201 C awan atas', '164.8 years', '14', '11.15 m/s2', '16h 6m', 'Hidrogen, helium, metana', 'Inti batu es dengan mantel es', '4.5 billion years', 'Neptunus memiliki angin supersonik dan Great Dark Spot yang dinamis.', 1, NULL),
  (10, 'celester', 'assets/images/planets/celester.webp', 'Fictional exoplanet', '18,000 km', '2.5e25 kg', '0.8 AU from parent star', '15 C rata-rata', '320 days', '3', '12.5 m/s2', '30h', 'Nitrogen, oksigen tipis, argon', 'Inti besi, kerak silikat, lautan dangkal', '3.2 billion years', 'Celester adalah dunia imajinatif untuk eksplorasi edukasi dengan lautan dangkal dan langit berwarna teal.', 1, NULL);

INSERT INTO planetarium_facts (planet_id, fact) VALUES
  (1, 'Mencakup lebih dari 99 persen massa Tata Surya'),
  (1, 'Cahaya Matahari mencapai Bumi dalam sekitar 8 menit'),
  (1, 'Badai Matahari dapat mengganggu sinyal satelit'),
  (2, 'Kecepatan orbit Mercury sekitar 47 km per detik'),
  (2, 'Memiliki inti besi yang besar dibanding ukuran totalnya'),
  (2, 'Variasi suhu siang dan malam mencapai 600 derajat'),
  (3, 'Rotasi Venus berlawanan arah dengan planet lain'),
  (3, 'Tekanan atmosfer permukaan 92 kali lebih besar dari Bumi'),
  (3, 'Awan asam sulfat memantulkan cahaya sehingga tampak sangat terang'),
  (4, 'Bumi memiliki satu satelit alami yaitu Bulan'),
  (4, 'Sekitar 71 persen permukaan Bumi tertutup air'),
  (4, 'Medan magnet Bumi melindungi dari radiasi Matahari'),
  (5, 'Mars memiliki gunung tertinggi Olympus Mons'),
  (5, 'Jejak aliran sungai kuno terlihat di permukaannya'),
  (5, 'Rover seperti Perseverance sedang mencari tanda kehidupan mikroba'),
  (6, 'Bintik Merah Besar adalah badai raksasa berusia berabad-abad'),
  (6, 'Memiliki medan magnet 20.000 kali lebih kuat dari Bumi'),
  (6, 'Memiliki lebih dari 95 bulan yang terkonfirmasi'),
  (7, 'Cincinnya tersusun dari partikel es dan debu'),
  (7, 'Bulan Titan memiliki atmosfer tebal dan danau metana cair'),
  (7, 'Saturn memiliki densitas rata-rata lebih kecil dari air'),
  (8, 'Uranus memiliki kemiringan sumbu hampir 98 derajat'),
  (8, 'Bulan terbesar bernama Titania dan Oberon'),
  (8, 'Pancaran warna biru berasal dari metana yang menyerap cahaya merah'),
  (9, 'Neptunus memiliki angin tercepat di Tata Surya'),
  (9, 'Bulan Triton mengorbit berlawanan arah rotasi Neptunus'),
  (9, 'Great Dark Spot muncul dan hilang seiring waktu'),
  (10, 'Celester dibuat untuk konten edukasi dan eksplorasi imajinatif'),
  (10, 'Diasumsikan memiliki lautan dangkal kaya mineral'),
  (10, 'Langitnya tampak teal karena partikel atmosfer halus');
