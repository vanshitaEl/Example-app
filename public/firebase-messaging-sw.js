
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";



/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
const firebaseConfig = {
  apiKey: "AIzaSyBXu7p10Q6m6Yl6RIG68EsqVcKGebxXshY",
  authDomain: "myfirstapp-46a5c.firebaseapp.com",
  projectId: "myfirstapp-46a5c",
  storageBucket: "myfirstapp-46a5c.appspot.com",
  messagingSenderId: "375483989847",
  appId: "1:375483989847:web:ff769d180b1bdb8ee60812",
  measurementId: "G-448K3Y7YWC"
};


// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

