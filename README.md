# SACS
Simple Access Control Service allows you to give or reject access to your content by using simple access token. The service is written in PHP so you can easily deploy it on your web hosting. There is also example Unity 3D script which consumes the service.

When you copy the service folder into your hosting, you can access the admin panel by adding /admin to the url. It is strongly recomended to protect the admin folder with password. 

To test the service type {path to the service}/api/{token} into the browser's address bar. You should see scrambled characters because the output is encrypted in case you don't have ssh encryption. Encryption key is set in both api.php and the client.
