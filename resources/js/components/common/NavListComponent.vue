<template>
        
    <ul class="nav navbar-nav navbar-right">
        <template v-if="login">
        <li><a :href="base_url">Subscription Form</a></li>
        <li><a :href="base_url + '/subscribers'" class="glyphicon glyphicon-user">Subscriber</a></li>
        <li><a href="javascript: void(0);" class="glyphicon glyphicon-log-out" @click="logout">Logout</a></li>
        </template>
        <template v-else>
              <li><a :href="base_url + '/login'">API Login</a></li>
              <li><a :href="base_url + '/register'">API Register</a></li>
          </template>
        </ul>
    </span>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    data(){
        return{
        }
    },
    computed:{
        ...mapState( [ 'csrf', 'base_url' ] ),

        login( ){
            return window._commonFn._checkLogin( );
        }
    },
    methods : {
         ...mapActions( [ 'setShow', 'setModal' ] ),

        logout(){
            window._localStorageFn._clearKeys( );
            window.location.href=js_parent_var.base_url + "/login";
        },

        /*show_listing(){
            this.setShow( 'listing' );
        }*/
    }
}
</script>
<style>
</style>
