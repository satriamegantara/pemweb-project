-- Insert all planets data into database
USE project;

-- Clear existing planet data
DELETE FROM planetarium_facts;
DELETE FROM planetarium;

-- Insert Sun
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('sun', 'Sun', 'sun.png', 'Bintang', '1,391,000 km', '1.989 × 10³⁰ kg', '', '5,500°C (permukaan), 15 juta°C (inti)', '-', '-', 'N/A', '274 m/s² (28x Bumi)', '25-35 hari (bervariasi berdasarkan latitude)', '', '73% Hydrogen, 25% Helium, 2% unsur lain', '4.6 miliar tahun', 
'Matahari adalah bintang di pusat Tata Surya kita dan merupakan objek paling masif dalam sistem kita, mengandung 99.86% dari seluruh massa Tata Surya. Sebagai bola plasma panas yang dipanaskan oleh reaksi fusi nuklir di intinya, Matahari adalah sumber energi utama bagi semua kehidupan di Bumi dan semua planet dalam Tata Surya.', 
'Matahari telah membentuk Tata Surya kami sekitar 4.6 miliar tahun yang lalu dari puing-puing awan molekuler raksasa. Dalam setiap detik, 600 juta ton hidrogen diubah menjadi helium melalui fusi nuklir, menghasilkan energi luar biasa yang memancar ke seluruh Tata Surya.', 
'SOHO (Solar and Heliospheric Observatory), Parker Solar Probe, Hinode', 
'Matahari telah dipelajari melalui berbagai teleskop dan satelit yang mengamati aktivitas Matahari, termasuk bintik Matahari, korona, dan angin Matahari. Parker Solar Probe telah menerima data paling dekat dari Matahari hingga saat ini.', 
1);

SET @sun_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@sun_id, 'Mengandung 99.86% dari seluruh massa Tata Surya'),
(@sun_id, 'Cahaya dari Matahari membutuhkan waktu 8 menit 20 detik untuk mencapai Bumi'),
(@sun_id, 'Umur Matahari sekitar 4.6 miliar tahun dan akan terus bersinar selama 5 miliar tahun lagi'),
(@sun_id, 'Diameter Matahari 109 kali lebih besar dari Bumi'),
(@sun_id, 'Suhu inti mencapai 15 juta derajat Celsius'),
(@sun_id, 'Matahari berputar lebih cepat di ekuator (25 hari) daripada di kutub (35 hari)'),
(@sun_id, 'Setiap detik, energi setara 100 miliar bom nuklir dihasilkan'),
(@sun_id, 'Badai Matahari dan flare dapat mengganggu komunikasi satelit di Bumi'),
(@sun_id, 'Medan magnet Matahari 1,000 kali lebih kuat dari Bumi'),
(@sun_id, 'Usia Matahari masih dalam pertengahan umurnya');

-- Insert Mercury
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('mercury', 'Mercury', 'mercury.png', 'Planet Terestrial', '4,879 km', '3.285 × 10²³ kg', '57.9 juta km dari Matahari', '-173°C (malam) hingga 427°C (siang)', '88 hari Bumi', '88 hari Bumi', 'Tidak ada', '3.7 m/s² (0.38x Bumi)', '176 hari Bumi', 'Hampir tidak ada (exosphere)', '', '', 
'Merkurius adalah planet terkecil dan terdekat dengan Matahari dalam Tata Surya kita. Dengan permukaan yang dipenuhi kawah mirip Bulan dan hampir tanpa atmosfer, Merkurius mengalami variasi suhu ekstrem yang paling besar di antara semua planet. Siang hari mencapai 427°C sedangkan malam mencapai -173°C, perbedaan 600°C!', 
'Merkurius telah dikenal sejak zaman kuno sebagai "bintang pagi" atau "bintang sore" ketika terlihat di ufuk. Planet ini dinamai sesuai dewa pesan Romawi karena gerakannya yang cepat di langit. Para astronom telah mengamati Merkurius selama ribuan tahun, meskipun sulit untuk diamati karena selalu berada dekat dengan Matahari.', 
'Mariner 10, MESSENGER, BepiColombo', 
'Merkurius telah dijelajahi oleh tiga misi: Mariner 10 (1974-1975), MESSENGER (2011-2015), dan BepiColombo (misi berkelanjutan sejak 2018). MESSENGER menemukan bukti es air yang mengejutkan di Planet paling panas ini.', 
1);

SET @mercury_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@mercury_id, 'Satu hari (176 hari Bumi) lebih panjang dari satu tahunnya (88 hari Bumi)'),
(@mercury_id, 'Dinamai sesuai dewa pesan Romawi yang terkenal karena kecepatannya'),
(@mercury_id, 'Memiliki inti besi yang mencakup 75% dari diameternya'),
(@mercury_id, 'Kecepatan orbital 47 km/detik, tercepat di Tata Surya'),
(@mercury_id, 'Permukaan penuh kawah akibat tumbukan asteroid selama 4 miliar tahun'),
(@mercury_id, 'Tidak memiliki satelit alami atau bulan'),
(@mercury_id, 'Medan magnetnya hanya 1% dari medan magnet Bumi'),
(@mercury_id, 'Misi MESSENGER mengungkapkan ada es air di kawah kutub yang selalu dalam bayangan'),
(@mercury_id, 'Variasi suhu mencapai 600°C antara siang dan malam'),
(@mercury_id, 'Rotasinya sangat lambat - hampir selalu menunjukkan wajah yang sama ke Matahari');

-- Insert Venus
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('venus', 'Venus', 'venus.png', 'Planet Terestrial', '12,104 km', '4.867 × 10²⁴ kg', '108.2 juta km dari Matahari', '462°C (rata-rata, planet terpanas)', '225 hari Bumi', '225 hari Bumi', 'Tidak ada', '8.87 m/s² (0.9x Bumi)', '243 hari Bumi (retrograde)', '96% CO₂, awan asam sulfat', '', '', 
'Venus adalah planet terpanas di Tata Surya dengan suhu lebih tinggi dari Merkurius meskipun lebih jauh dari Matahari. Atmosfer tebal menciptakan efek rumah kaca ekstrem yang menjebak panas. Uniknya, Venus berputar mundur (retrograde) dan satu harinya (243 hari) lebih panjang dari satu tahunnya (225 hari).', 
'Venus dinamai sesuai dewi cinta dan keindahan Romawi karena keindahannya di langit. Planet ini telah menarik perhatian astronom sejak zaman kuno. Pada era Uni Soviet, Venus menjadi target utama eksplorasi dengan program Venera yang melakukan lebih dari 10 pendaratan.', 
'Venera (Soviet), Mariner 2, Pioneer Venus, Magellan, Akatsuki', 
'Venus telah dikunjungi oleh puluhan misi dari berbagai negara. Program Venera Uni Soviet melakukan 10 pendaratan yang berhasil di permukaan, satu-satunya yang mendarat di planet lain. Magellan menciptakan peta radar yang detail, dan Akatsuki (JAXA) saat ini mengorbit Venus untuk mempelajari atmosfernya.', 
1);

SET @venus_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@venus_id, 'Venus berputar mundur (retrograde) - satu-satunya planet besar dengan rotasi seperti ini'),
(@venus_id, 'Satu hari (243 hari) lebih panjang dari satu tahunnya (225 hari Bumi)'),
(@venus_id, 'Dijuluki "saudara kembar Bumi" karena ukuran dan komposisi yang hampir sama'),
(@venus_id, 'Tekanan atmosfer 92 kali Bumi (setara dengan berada 900m di bawah laut)'),
(@venus_id, 'Objek paling terang di langit malam setelah Bulan'),
(@venus_id, 'Tidak memiliki satelit alami'),
(@venus_id, 'Suhu permukaan cukup panas untuk melelehkan timah'),
(@venus_id, 'Hujan asam sulfat terjadi di atmosfer atas tetapi menguap sebelum mencapai permukaan'),
(@venus_id, 'Angin di atmosfer atas bergerak 60 kali lebih cepat dari rotasi planet'),
(@venus_id, 'Lebih dari 1,600 gunung berapi besar teridentifikasi di permukaannya');

-- Insert Earth
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('earth', 'Earth', 'earth.png', 'Planet Terestrial', '12,742 km', '5.972 × 10²⁴ kg', '149.6 juta km dari Matahari (1 AU)', '-88°C hingga 58°C (rata-rata 15°C)', '365.25 hari', '365.25 hari', '1 (Bulan)', '9.8 m/s²', '24 jam', '78% N₂, 21% O₂, 1% lainnya', '', '', 
'Bumi adalah planet ketiga dari Matahari dan satu-satunya tempat di alam semesta yang diketahui mendukung kehidupan. Dengan kombinasi unik air cair, atmosfer pelindung yang kaya oksigen, medan magnet yang kuat, dan posisi ideal di zona layak huni, Bumi adalah rumah bagi jutaan spesies makhluk hidup dari mikroba hingga manusia.', 
'Bumi terbentuk sekitar 4.54 miliar tahun yang lalu dari puing-puing cakram protoplanet. Selama jutaan tahun pertama, Bumi mengalami bombardmen asteroid yang intens. Setelah itu, Bumi berevolusi menjadi planet yang layak huni dengan munculnya kehidupan sederhana sekitar 3.8 miliar tahun yang lalu, diikuti evolusi organisme kompleks hingga manusia modern muncul sekitar 300,000 tahun yang lalu.', 
'Jutaan satelit mengorbit, ISS (International Space Station), Mars rovers (dari Bumi)', 
'Bumi adalah planet yang paling banyak dieksplorasi karena merupakan rumah kita. Kami telah menjelajahi samudera, menembus gunung tertinggi, mencapai kutub, dan bahkan pergi ke luar angkasa dari planet ini. Jutaan satelit orbiting memonitor iklim, cuaca, dan komunikasi global.', 
1);

SET @earth_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@earth_id, '71% permukaan ditutupi air (97% air asin laut, 3% air tawar)'),
(@earth_id, 'Atmosfer melindungi kehidupan dari radiasi berbahaya Matahari'),
(@earth_id, 'Rotasi Bumi melambat 17 milidetik per 100 tahun karena efek pasang surut Bulan'),
(@earth_id, 'Medan magnet melindungi dari angin Matahari dan radiasi kosmik'),
(@earth_id, 'Satu-satunya planet dengan lempeng tektonik aktif'),
(@earth_id, 'Titik tertinggi: Gunung Everest (8,849m), terendah: Palung Mariana (-10,994m)'),
(@earth_id, 'Memiliki lebih dari 8.7 juta spesies makhluk hidup'),
(@earth_id, '70% oksigen dihasilkan oleh fitoplankton di lautan'),
(@earth_id, 'Inti Bumi sepanas permukaan Matahari (sekitar 5,500°C)'),
(@earth_id, 'Manusia telah mengorbit Bumi, mendarat di Bulan, dan mengirim probe ke seluruh Tata Surya');

-- Insert Mars
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('mars', 'Mars', 'mars.png', 'Planet Terestrial', '6,779 km', '6.417 × 10²³ kg', '227.9 juta km dari Matahari', '-140°C hingga 20°C (rata-rata -65°C)', '687 hari Bumi', '687 hari Bumi', '2 (Phobos & Deimos)', '3.71 m/s² (0.38x Bumi)', '24.6 jam (sangat mirip Bumi)', '95% CO₂, sangat tipis (1% Bumi)', '', '', 
'Mars dijuluki "Planet Merah" karena permukaan yang kaya akan oksida besi (karat). Dengan bukti kuat adanya air cair di masa lalu, Mars menjadi target utama eksplorasi dan kolonisasi manusia di masa depan. Planet ini memiliki musim, kutub es, badai debu skala planet, dan fitur geologi paling ekstrem di Tata Surya.', 
'Mars telah menarik imajinasi manusia selama berabad-abad, dengan mitos tentang kehidupan di planet ini. Pada abad ke-19, astronom percaya melihat "kanal-kanal" di Mars. Eksplorasi modern dimulai dengan Mariner 4 (1965). Sekarang, lebih dari 50 misi telah dikirim ke Mars, dengan beberapa masih aktif.', 
'Mariner 4, Viking 1-2, Pathfinder, Spirit, Opportunity, Curiosity, Perseverance, Ingenuity', 
'Mars adalah planet paling banyak dikunjungi selain Bumi. Rover Curiosity telah menjelajahi sejak 2012, diikuti Perseverance sejak 2021 dengan drone Ingenuity. Semua misi robotik ini mencari tanda-tanda kehidupan masa lalu dan menilai kelayakan untuk kolonisasi manusia.', 
1);

SET @mars_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@mars_id, 'Dua bulan kecil: Phobos dan Deimos (kemungkinan asteroid yang tertangkap)'),
(@mars_id, 'Olympus Mons: gunung berapi tertinggi (21km, 2.5x Everest)'),
(@mars_id, 'Valles Marineris: ngarai terbesar (4,000km panjang, 7km dalam)'),
(@mars_id, 'Kutub es terbuat dari air beku dan CO₂ beku (dry ice)'),
(@mars_id, 'Badai debu dapat berlangsung berbulan-bulan dan menutupi seluruh planet'),
(@mars_id, 'Jejak sungai kuno dan danau menunjukkan air pernah mengalir'),
(@mars_id, 'Methane terdeteksi di atmosfer, kemungkinan dari aktivitas geologi atau mikroba'),
(@mars_id, 'Rover Curiosity dan Perseverance sedang menjelajahi dan mencari bukti kehidupan'),
(@mars_id, 'Hari Mars (sol) hanya 39 menit lebih panjang dari hari Bumi'),
(@mars_id, 'Calon destinasi pertama untuk koloni manusia');

-- Insert Jupiter
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('jupiter', 'Jupiter', 'jupiter.png', 'Gas Giant (Planet Raksasa Gas)', '139,820 km', '1.898 × 10²⁷ kg', '778.5 juta km dari Matahari', '-108°C (rata-rata, puncak awan)', '12 tahun Bumi', '12 tahun Bumi', '95 (diketahui, termasuk 4 bulan Galilean)', '24.8 m/s² (2.5x Bumi)', '10 jam (tercepat di Tata Surya)', '90% H₂, 10% He, jejak CH₄, NH₃', '', '', 
'Jupiter adalah planet terbesar dalam Tata Surya, dengan massa 2.5 kali lebih besar dari semua planet lain digabungkan. Sebagai gas giant, Jupiter terdiri dari hidrogen dan helium dengan kemungkinan inti berbatu. Fitur paling terkenal adalah Great Red Spot, badai antisiklon raksasa yang telah berlangsung setidaknya 400 tahun dan lebih besar dari Bumi sendiri.', 
'Jupiter telah dikenal sejak zaman kuno dan dinamai sesuai raja dewa Romawi. Galileo Galilei menemukan 4 bulan terbesar (bulan Galilean) pada 1610, menjadi bukti pertama bahwa benda langit tidak mengorbit Bumi. Jupiter menjadi target eksplorasi sejak era ruang angkasa dengan pesawat luar angkasa Pioneer dan Voyager.', 
'Pioneer 10-11, Voyager 1-2, Galileo, Cassini, JUNO', 
'Jupiter telah dikunjungi oleh semua pesawat luar angkasa yang dikirim ke outer solar system. JUNO (NASA) saat ini mengorbit Jupiter dan menyelami atmosfernya. Data dari misi ini mengungkapkan badai dalam skala global, medan magnet ekstrem, dan potential kehidupan di bulan-bulannya.', 
1);

SET @jupiter_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@jupiter_id, '95 bulan diketahui, termasuk 4 bulan Galilean: Io, Europa, Ganymede, Callisto'),
(@jupiter_id, 'Great Red Spot: badai antisiklon 2x lebih besar dari Bumi, berlangsung 400+ tahun'),
(@jupiter_id, 'Hari terpendek di Tata Surya: hanya 10 jam (berputar sangat cepat)'),
(@jupiter_id, 'Medan magnet 20,000x lebih kuat dari Bumi'),
(@jupiter_id, 'Massa Jupiter 2.5x massa semua planet lain digabungkan'),
(@jupiter_id, 'Melindungi Bumi dengan menarik asteroid dan komet (gravitasi massive)'),
(@jupiter_id, 'Memiliki sistem cincin tipis yang sulit dilihat dari Bumi'),
(@jupiter_id, 'Europa kemungkinan memiliki lautan air di bawah permukaannya'),
(@jupiter_id, 'Io adalah benda yang paling vulkanis dalam Tata Surya'),
(@jupiter_id, 'Jika 80x lebih masif, Jupiter bisa menjadi bintang kecil');

-- Insert Saturn
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('saturn', 'Saturn', 'saturn.png', 'Gas Giant (Planet Raksasa Gas)', '116,460 km', '5.683 × 10²⁶ kg', '1.4 miliar km dari Matahari', '-138°C (rata-rata, puncak awan)', '29 tahun Bumi', '29 tahun Bumi', '146 (diketahui, Titan adalah terbesar)', '10.4 m/s² (1.1x Bumi)', '10.7 jam', '96% H₂, 3% He, jejak CH₄, NH₃, H₂O', '', '', 
'Saturnus terkenal karena sistem cincin spektakulernya yang terbuat dari miliaran partikel es dan batu, menciptakan pemandangan paling indah di Tata Surya. Sebagai gas giant kedua terbesar, Saturnus memiliki komposisi serupa dengan Jupiter. Kepadatannya sangat rendah (0.687 g/cm³) sehingga bisa mengapung di air! Titan, bulan terbesarnya, adalah satu-satunya bulan dengan atmosfer tebal.', 
'Saturnus telah dikenal sejak zaman kuno dan dinamai sesuai dewa pertanian Romawi. Christiaan Huygens pertama kali mengamati cincinnya pada 1655. Eksplorasi modern dimulai dengan Pioneer 11 dan Voyager 1-2, diikuti misi Cassini yang spektakuler selama 13 tahun.', 
'Pioneer 11, Voyager 1-2, Cassini-Huygens', 
'Misi Cassini-Huygens (2004-2017) adalah eksplorasi paling sukses Saturnus, dengan Huygens mendarat di Titan. Data terbaru menunjukkan Enceladus memiliki lautan bawah permukaan yang mungkin mendukung kehidupan, membuat Saturnus menjadi fokus pencarian kehidupan di Tata Surya.', 
1);

SET @saturn_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@saturn_id, 'Sistem cincin paling spektakuler: lebar 280,000 km tapi tebal hanya 10-100 meter'),
(@saturn_id, '146 bulan diketahui, dengan Titan memiliki atmosfer lebih tebal dari Bumi'),
(@saturn_id, 'Kepadatan terendah: 0.687 g/cm³ (bisa mengapung di kolam air!)'),
(@saturn_id, 'Angin di ekuator mencapai 1,800 km/jam'),
(@saturn_id, 'Cincin terbuat dari 99% es air dengan sedikit partikel batu'),
(@saturn_id, 'Enceladus menyemburkan geyser air dari lautan bawah permukaannya'),
(@saturn_id, 'Hexagon misterius di kutub utara: badai berbentuk segi enam yang stabil'),
(@saturn_id, 'Satu musim berlangsung 7 tahun (seperempat dari orbitnya)'),
(@saturn_id, 'Titan memiliki danau dan lautan hydrocarbon di permukaannya'),
(@saturn_id, 'Cassini-Huygens mendarat di Titan dan menemukan permukaan yang kompleks');

-- Insert Uranus
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('uranus', 'Uranus', 'uranus.png', 'Ice Giant (Planet Es Raksasa)', '50,724 km', '8.681 × 10²⁵ kg', '2.9 miliar km dari Matahari', '-197°C (rata-rata)', '84 tahun Bumi', '84 tahun Bumi', '28 (diketahui)', '8.7 m/s² (0.9x Bumi)', '17.2 jam (retrograde)', '83% H₂, 15% He, 2% CH₄ (methane)', '', '', 
'Uranus adalah ice giant dengan warna biru-hijau karena methane di atmosfernya yang menyerap cahaya merah. Yang paling unik dan aneh: rotasi aksial Uranus 98 derajat, membuat planet ini berputar "miring" atau pada sisinya seperti bola bowling yang digulingkan. Akibatnya, satu kutub menghadap Matahari selama 42 tahun, sementara kutub lain dalam kegelapan total.', 
'Uranus adalah planet pertama yang ditemukan di era teleskop (1781 oleh William Herschel), memperluas batas Tata Surya yang diketahui. Ia tidak diketahui di zaman kuno karena terlalu redup untuk dilihat dengan mata telanjang. Voyager 2 adalah satu-satunya pesawat yang mengunjunginya pada 1986.', 
'Voyager 2', 
'Uranus telah dikunjungi hanya sekali oleh Voyager 2 pada 1986, menjadi planet yang paling sedikit dieksplorasi di Tata Surya. Flyby singkat ini memberikan gambar dan data berharga, namun para ilmuwan masih menginginkan misi orbital untuk studi lebih mendalam.', 
1);

SET @uranus_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@uranus_id, 'Berputar pada sisinya dengan kemiringan 98 derajat (hampir horizontal)'),
(@uranus_id, 'Planet pertama ditemukan dengan teleskop oleh William Herschel pada 1781'),
(@uranus_id, '28 bulan diketahui, dinamai berdasarkan karakter Shakespeare dan Pope'),
(@uranus_id, 'Warna biru-hijau karena methane yang menyerap cahaya merah'),
(@uranus_id, 'Satu musim berlangsung 21 tahun Bumi - kutub dalam kegelapan/terang berkelanjutan'),
(@uranus_id, 'Suhu terendah di atmosfer: -224°C (tercatat oleh Voyager 2)'),
(@uranus_id, 'Memiliki 13 cincin tipis dan redup'),
(@uranus_id, 'Miranda (bulan): permukaan paling beragam dan aneh di Tata Surya'),
(@uranus_id, 'Hanya pernah dikunjungi sekali oleh Voyager 2 pada Januari 1986'),
(@uranus_id, 'Revolusi penuh membutuhkan 84 tahun Bumi');

-- Insert Neptune
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('neptune', 'Neptune', 'neptune.png', 'Ice Giant (Planet Es Raksasa)', '49,244 km', '1.024 × 10²⁶ kg', '4.5 miliar km dari Matahari', '-214°C (rata-rata)', '165 tahun Bumi', '165 tahun Bumi', '16 (diketahui, Triton adalah terbesar)', '11.2 m/s² (1.1x Bumi)', '16 jam', '80% H₂, 19% He, 1.5% CH₄, jejak H₂O, NH₃', '', '', 
'Neptunus adalah planet terjauh dari Matahari dalam Tata Surya dan ice giant dengan warna biru cerah karena methane. Planet ini memiliki angin tercepat di Tata Surya, dengan kecepatan hingga 2,100 km/jam (Mach 3 relatif terhadap kecepatan suara!). Neptunus memancarkan 2.6 kali lebih banyak energi daripada yang diterimanya dari Matahari, menunjukkan ada sumber panas internal.', 
'Neptunus adalah planet pertama yang ditemukan melalui perhitungan matematis sebelum observasi visual (1846), diprediksi dari gangguan gravitasi pada orbit Uranus. Ini merupakan triumph matematika dan fisika. Voyager 2 adalah satu-satunya pesawat yang telah mengunjunginya pada 1989.', 
'Voyager 2', 
'Neptunus hanya dikunjungi sekali oleh Voyager 2 pada 1989, menjadi pencapaian luar biasa saat mencapai planet terjauh yang diketahui. Misi singkat ini mengubah pemahaman kita tentang ice giants, menemukan Great Dark Spot dan badai-badai lainnya.', 
1);

SET @neptune_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@neptune_id, 'Angin tercepat di Tata Surya: hingga 2,100 km/jam (lebih cepat dari suara)'),
(@neptune_id, 'Ditemukan melalui perhitungan matematis (1846) sebelum observasi visual'),
(@neptune_id, 'Triton (bulan terbesar) memiliki orbit retrograde (unik dan aneh)'),
(@neptune_id, 'Triton perlahan jatuh ke Neptunus dan akan hancur dalam 3.6 miliar tahun'),
(@neptune_id, 'Great Dark Spot: badai seukuran Bumi yang muncul dan menghilang'),
(@neptune_id, 'Warna biru lebih intens daripada Uranus karena konsentrasi methane lebih tinggi'),
(@neptune_id, 'Memiliki 6 cincin redup dan tidak lengkap'),
(@neptune_id, 'Satu tahun Neptunus = 165 tahun Bumi (baru menyelesaikan 1 orbit sejak ditemukan)'),
(@neptune_id, 'Triton adalah objek terdingin: -235°C (sesuai dengan teori bahwa ia berasal dari Kuiper Belt)'),
(@neptune_id, 'Memancarkan 2.6x lebih banyak energi dari panas internal yang tidak diketahui asalnya');

-- Insert Celester
INSERT INTO planetarium (name, english_name, image, type, diameter, mass, distance, temperature, orbit_period, year_length, moons, gravity, day_length, atmosphere, composition, age, description, history, missions, exploration, is_active) VALUES
('celester', 'Celester', 'celester.png', 'Dwarf Planet (Planet Kerdil)', '~2,400 km (diperkirakan)', 'Tidak diketahui dengan pasti', 'Beyond Neptunus (Kuiper Belt)', '-230°C hingga -240°C (diperkirakan)', '~250 tahun Bumi (diperkirakan)', '~250 tahun Bumi (diperkirakan)', 'Berpotensi 1-2 (belum dikonfirmasi)', '~0.4 m/s² (diperkirakan)', '', '', 'Es (H₂O, CH₄, N₂) dan batuan', '', 
'Celester adalah benda langit misterius yang terletak di pinggiran Tata Surya dalam wilayah Kuiper Belt. Sebagai salah satu penemuan terbaru, Celester masih menjadi misteri bagi astronom yang sedang mempelajari komposisi dan karakteristiknya lebih lanjut. Kemungkinan terbuat dari es dan batuan dengan permukaan yang sangat dingin dan gelap.', 
'Celester adalah penemuan relatif baru yang menambah daftar objek trans-Neptunian yang telah ditemukan dalam beberapa dekade terakhir. Penemuan ini memperkaya pemahaman kita tentang struktur dan populasi Kuiper Belt, wilayah yang dipenuhi ribuan benda es di pinggiran Tata Surya.', 
'Tidak ada misi yang telah dikirim', 
'Celester belum pernah dikunjungi oleh pesawat luar angkasa manapun. Observasi saat ini dilakukan dari Bumi dan teleskop luar angkasa. Studi lebih lanjut diperlukan untuk mengkonfirmasi karakteristiknya. Jika ada misi masa depan ke Kuiper Belt, Celester akan menjadi salah satu target utama untuk penelitian.', 
1);

SET @celester_id = LAST_INSERT_ID();
INSERT INTO planetarium_facts (planet_id, fact) VALUES
(@celester_id, 'Terletak di wilayah Kuiper Belt yang gelap dan dingin'),
(@celester_id, 'Salah satu dari ribuan objek trans-Neptunian yang baru ditemukan'),
(@celester_id, 'Kemungkinan komposisi: es (air, methane, nitrogen) dan batuan'),
(@celester_id, 'Permukaan mungkin tertutup methane, nitrogen, dan es air'),
(@celester_id, 'Orbitnya sangat elips dan memakan waktu ratusan tahun'),
(@celester_id, 'Cahaya Matahari 1,600x lebih redup dibanding di Bumi'),
(@celester_id, 'Bisa memiliki satu atau dua satelit kecil (belum dikonfirmasi)'),
(@celester_id, 'Suhu ekstrem membuat planet ini beku dan stabil'),
(@celester_id, 'Perjalanan cahaya dari Matahari membutuhkan lebih dari 4 jam'),
(@celester_id, 'Representasi dari banyak objek misterius yang masih belum terjamah di pinggiran Tata Surya');
