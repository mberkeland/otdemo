# otdemo

This demo consists of a Frontend (written in Vue.js), and a backend (in PHP)

# Frontend in Vue,js

npm install

Set the variables in /src/components/harness.vue:\
        phone: "1408xxxxxx",\
        region: "US",\
        tokbox_key: "xxxxxx",\

Set the backend server address in /src/base.js:\
        export const $BASE = 'https://abcde.ngrok.io';

To run:\
   npm run dev

# Backend PHP

Located in the /backend directory, run\
   composer install

Edit the /backend/otDemo.php file, around line 17, with the appropriate values:\
$key='xxxxxx';  //Nexmo Key\
$secret='xxxxxxx';  // Nexmo secret\
$from='1415xxxxxxxx'; // Nexmo LVN Phone Number\
$tokbox_key='xxxxxx'; // TokBox Key\
$tokbox_secret='xxxxxxxxxxxxxxxxx';  // TokBox Secret\


