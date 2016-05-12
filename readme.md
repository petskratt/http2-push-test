### Very Simple HTTP/2 (server push) test ###

Created to compare speed of HTTP 1.1 vs HTTP/2 vs HTTP/2 + server push.

Just an array of logos, served with unique cache-buster attribute on each reload.
Also builds a Link: header for HTTP/2 server push (that seems to work on Firefox, but not on Chrome).

And random_bytes() is used, so it needs PHP 7 :-)