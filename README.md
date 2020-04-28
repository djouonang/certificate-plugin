# certificate-plugin
 
WordPress plugin that automatically generates certificates and success cards in one click and saves all the information to a database.

Features

- The plugin saves all the information of candidates to a database which can be retrieved later on the website of the certifying institution to verify the certificates. There are two ways to verify a certificate:

1. There is a verification search bar on the website of the certifying institution where you can key in the name or certificate ID for the certificate you are trying to veriy and the candidate's detail will show up with his details and picture on the search results thus authenticating that the trainee had successfully completed the training.

2. The second verification technique involves using a QR code scanning application to scan the QR code on the certificate. This will pull the candidate's details from the database of the certifying institution 

- The plugin automatically calculates the expiry date of the certificate achieved and prints it on the certificate generated.

- The plugin automatically generates a QR code and bar code which are also printed on the certificate generated. The QR code is used to verify the authenticity of the certificate by means of a QR code scanner.

- Apart from the certificate the plugin also generates a success card or badge for the successful candidate.

- The plugin uses dompdf library to convert the certificate from its html and css design to pdf which can be printed out.
