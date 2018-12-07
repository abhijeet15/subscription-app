<template>
  <div v-show="page.show == 'edit' || page.show == 'add'" id="idx-page-edit" class="col-md-8 col-md-offset-2">
    <div  class="col-md-8 col-md-offset-2">
            <div class="panel panel-default form-row">
                <div class="panel-heading">Subscription Sample Form</div>

                <div class="panel-body">
                  <div v-if='page_data.success_msg && ( page_data.success_msg || {} ).length' class="alert alert-success">
                    {{page_data.success_msg}}
                  </div>
                    <form @submit.prevent="add">

                      <template v-for="field in fields">
                        <div :class="{'form-group' : true, 'has-error': (errors[ 'fields.' + field.key ] || errors[ field.key ])}">
                        <label :for="field.key">{{field.title}} *</label>
                        <!-- Date Picker. -->
                        <template v-if="field.type == 'date'">
                          <datepicker
                              name="dob"
                              :placeholder="'Enter' + field.title"
                              :bootstrapStyling="true"
                              :calendarButton="true"
                              :clearButton="true"
                              :format="format"
                              v-model="model['fields'][ field.key ]"
                            ></datepicker>
                        </template>

                        <!-- Boolean. -->
                        <template v-else-if="field.type == 'boolean'">
                          <input type="radio" class="is-invalid" :name="field.key" :id="field.key" v-model="model['fields'][ field.key ]" value="1"> Yes, 
                          <input type="radio" class="is-invalid" :name="field.key" :id="field.key" v-model="model['fields'][ field.key ]" value="0"> No
                        </template>

                        <!-- String. -->
                        <template v-else>
                          <input type="text" class="form-control is-invalid" :id="field.key" :placeholder="'Enter' + field.title" v-model="model['fields'][ field.key ]">
                        </template>

                        <span v-show="(errors[ 'fields.' + field.key ] || errors[ field.key ])" class="help-block">{{(errors[ 'fields.' + field.key ] || errors[ field.key ])}}</span>
                        </div>  
                      </template>
                      

                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
    </div>
  </div>
</template>

<script>

import { mapState, mapActions } from 'vuex';

import Datepicker from 'vuejs-datepicker';


    export default {
        data(){
            return{
              format: "yyyy-MM-dd"
            }
        },
        mounted(){
          window._commonFn._redirect( );
        },
        components: {
          Datepicker
        },
        computed:{
             ...mapState( [ 'page', 'page_data', 'all_categories' ] ),

             fields(){

              if( this.page.show == "edit" ){
                for( var x in this.page_data.model.fields ) {
                  this.model.fields[ this.page_data.model.fields[ x ].key ] = this.page_data.model.fields[ x ].value;
                }
                return this.page_data.model.fields;
              } else {
                return js_parent_var.custom_fields;
              }
             },
             model( ){
                let model = {};
                // model.state = "active";
                model['fields'] = {};
                return model;
             },
             errors( ){
                return this.page_data.error_msg
             }
        },
        methods : {
            ...mapActions( [ 'setShow', 'subscribe', 'showError', 'showSuccess' ] ),

            add( event ) {

              this.subscribe( this._format( ) )
                .then(response => {
                    if( response.status == 201 ) {
                      this.showSuccess( "Subscribed succcessfully!!!" );
                    } else if( response.status == 200 ) {
                      this.setShow( 'listing' );
                      this.showSuccess( "Information Updated succcessfully!!!" );
                    }
                }, error => {
                  if( error.response.status == 422 ) {
                    this.showError( error.response.data )
                  } else {
                    alert( "Some internal issue, Please contant admin!!!" );
                  }
                });
            },

            _format( ){
              var obj = {};
              if(this.page_data.model.id)
                obj.id = this.page_data.model.id

              obj.name = this.model.fields.name;
              obj.email = this.model.fields.email;
              obj.fields = this.model.fields;
              obj.state = "active";

              for( var x in this.fields )
              {
                if( this.fields[ x ][ 'type' ] == "date" ){
                  if( this.model[ 'fields' ][ this.fields[ x ][ 'key' ] ] ){
                    var _t = new Date(this.model[ 'fields' ][ this.fields[ x ][ 'key' ] ])
                    var _date = _t.getDate( );
                    var _month = _t.getMonth( )+1;
                    if( _date < 10 )  _date = "0" + _date;
                    if( _month < 10 )  _month = "0" + _month;
                    obj.fields[ this.fields[ x ][ 'key' ] ] = _t.getFullYear( ) + "-" + _month + "-" + _date;
                  }
                  
                }
              }
              return obj;
            }
        }
    }
</script>

<style scoped>
</style>
