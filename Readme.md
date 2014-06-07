PHP CORS Server

See index.php for basic configuration options.

Include class.cors.php before you send any content (headers will be sent by this function) and call the respond() function of the object after setting basic options.

If you want to manage CORS by domain, simply store the configuration data in a database (or, other storage mechanism) and use the Origin header to lookup which config options to set.

