-- Seed data for achievements (safe to re-run)
-- Requires table `achievements` from database.sql

INSERT INTO achievements (code, title, description, target_label, accent, is_active)
VALUES
  ('EXP', 'Pathfinder', 'Kunjungi berbagai planet dan habiskan waktu minimal 2 menit di masing-masing.', '20 planet dikunjungi (>= 120 detik)', '#7dc4ff', 1),
  ('QM', 'Quiz Master', 'Raih skor tinggi secara konsisten pada kuis Planetarium.', '5 skor kuis >= 80%', '#f5a524', 1)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  description = VALUES(description),
  target_label = VALUES(target_label),
  accent = VALUES(accent),
  is_active = VALUES(is_active),
  updated_at = CURRENT_TIMESTAMP;
