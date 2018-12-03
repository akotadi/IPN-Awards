/**
 * Insert # user #
 */
INSERT INTO user (username, email, password, verified, idtype) VALUES ('admin1', 'admin1IPN@einrot.com', '', 1, (SELECT idType FROM type WHERE name LIKE '%Administrator%'));
