import './bootstrap';


import {createApp} from "vue";
import UserList from "./components/UserList.vue";



const app=createApp({});



app.component('userList', UserList)



app.mount('#app');
