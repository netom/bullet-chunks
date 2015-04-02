Bullet-Chunks
=============

[![Build Status](https://travis-ci.org/netom/bullet-chunks.svg)](https://travis-ci.org/netom/bullet-chunks)

Bullet-Chunks is a Response class for the Bullet PHP framework.

It helps reducing the memory/disk footprint and the response time of Bullet PHP
pages or API endpoints where lot of data needs to be returned.

Often such data is read from a database as a list of records, or from a file
as binary chunks of lines.

If a Traversable (or similarly foreach-able) class can be (or already is)
wrapped around the data where it isn't fetched at once, but record-by-record
or line-by-line, this response object can emit the HTTP response as the data
arrives, without loading all of it into a large memory buffer or temporary file.

As a result, the browser or API client will start receiving the data as the
first item arrives, and the memory footprint won't depend on the amount of
data being transferred.

Chunked encoding
----------------



Installation
------------

Usage
-----

Running the tests
-----------------

