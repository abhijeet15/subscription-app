<template>
    <div  class="col-md-8 col-md-offset-2">
            <div class="panel panel-default form-row">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form @submit.prevent="add">

                      <div :class="{'form-group' : true, 'has-error': errors.name}">
                        <label for="name">Name *</label>
                        <input type="text" class="form-control is-invalid" id="name" placeholder="Enter Name" v-model="model.name">
                        <span v-show="errors.name" class="help-block">{{errors.name}}</span>
                      </div>

                      <div :class="{'form-group' : true, 'has-error': errors.email}">
                        <label for="email">Email address *</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" v-model="model.email">
                        <small id="emailHelp" class="form-text text-muted">Example: abc@gmail.com</small>
                        <span v-show="errors.email" class="help-block">{{errors.email}}</span>
                      </div>

                      <div :class="{'form-group' : true, 'has-error': errors.password}">
                        <label for="password">Password *</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Password" v-model="model.password">
                        <span v-show="errors.password" class="help-block">{{errors.password}}</span>
                      </div>

                      <div :class="{'form-group' : true, 'has-error': errors.password_confirmation}">
                        <label for="password_confirmation">Confirm Password *</label>
                        <input type="password" class="form-control" id="password_confirmation" placeholder="Enter Confirm Password" v-model="model.password_confirmation">
                        <span v-show="errors.password_confirmation" class="help-block">{{errors.password_confirmation}}</span>
                      </div>
                      <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
</template>

<script>

import { mapState, mapActions } from 'vuex';

export default {
    data(){
        return{
          format: "yyyy-MM-dd",
          model: {}
        }
    },
    computed:{
         ...mapState( [ 'page_data', 'base_url' ] ),

         errors( ){
            return this.page_data.error_msg
         }
    },
    methods : {
        ...mapActions( [ 'register', 'showError', 'showSuccess' ] ),

        add( event ) {
          window._localStorageFn._clearKeys();
          this.register( this.model )
            .then(response => {
                if( response.status == 201 ) {
                  window._localStorageFn._set( 'name', response.data.data.name );
                  window._localStorageFn._set( 'email', response.data.data.email );
                  window._localStorageFn._set( 'api_token', response.data.data.api_token );
                  window.location.href=this.base_url;
                }
            }, error => {
              if( error.response.status == 422 ) {
                this.showError( error.response.data.errors )
              } else {
                alert( "Some internal issue, Please contant admin!!!" );
              }
            });
        }
    }
}
</script>

<style scoped>
</style>
