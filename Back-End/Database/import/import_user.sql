/**
 * Insert # user #
 */
INSERT INTO user (username, email, password, verified, idtype) VALUES ('admin1', 'admin1IPN@einrot.com', '$2y$10$VPH2RrSBBFzYL1LQ0hndEeqZfF8kL4eq/TwKA1yRt6kJ6/x8icI1S', 1, (SELECT idType FROM type WHERE name LIKE '%Administrator%'));
