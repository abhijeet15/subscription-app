<template>
    <div v-show="page.show == 'listing'" id="idx-page-listing" class="col-md-12">
        
        <div class="panel panel-default">
            <div class="panel-heading">Manage Subscription(as per login user)</div>
           
            <div v-if='page_data.success_msg' class="alert alert-success">
              {{page_data.success_msg}}
            </div>
            <div v-if='page_data.length' class="alert alert-danger">
              {{page_data.error_msg}}
            </div>

            <div class="panel-body">
            <form @submit.prevent="do_search">
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th style="width: 1%;" scope="col">#</th>
                    <th style="width: 15%;" scope="col">Name</th>
                    <th style="width: 15%;" scope="col">Email</th>
                    <th style="width: 15%;" scope="col">Fields</th>
                    <th style="width: 15%;" scope="col">State</th>
                    <th style="width: 10%;" scope="col">Added Date</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="has_records">
                      <tr v-for="record in collection">
                        <td scope="row">{{ record[ 'id' ] }}</td>
                        <td>{{ record.name }}</td>
                        <td>{{ record[ 'email' ] }}</td>
                        <td>
                          <template v-if="record.fields.length>0">
                            <table>
                                <tr v-for="f in record.fields">
                                  <th>{{f.key}}</th>
                                  <td>{{f.value}}</td>
                                </tr>
                            </table>
                          </template>
                        </td>
                        <td>{{ record[ 'state' ] }}</td>
                        <td>{{ record.created_at }}</td>
                        <td>
                          <div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Actions
                                  <span class="glyphicon glyphicon-chevron-down"></span>
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" @click="do_edit( record.id )" href="javascript: void( 0 );">Edit</a>
                                  <a class="dropdown-item"  @click="do_delete( record[ 'id' ] )" href="javascript: void( 0 );">Delete</a>
                              </div>
                          </div>

                        </td>
                      </tr>

                      <tr >
                        <td colspan="100%"><pagination></pagination></td>
                      </tr>
                  </template>
                  <template v-else>
                      <tr >
                        <td colspan="100%">No Records Found...</td>
                      </tr>
                  </template>
                      
                </tbody>
              </table>
            </form>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from './../common/PaginationComponent.vue';
import { mapState, mapActions } from 'vuex';
import Datepicker from 'vuejs-datepicker';

    export default {
        data(){
            return{
              format: "yyyy-MM-dd"
            }
        },
        mounted( ){
          this.listing( );
        },
        components: {
            'pagination': pagination,
            Datepicker
        },
        computed:{
             ...mapState( [ 'page_heading', 'page', 'base_url', 'page_data', 'all_categories' ] ),

            has_records( ){
              return this.collection.length > 0
            },
            collection( ){
              return this.page_data.collection;
            },
            filters( ){
                return this.page_data.filters;
             }
        },
        methods : {
            ...mapActions( [ 'setShow', 'setModal', 'getSubscriptions', 'getSubscription', 'getDeleteSubscription', 'showSuccess' ] ),

            listing( ) {
              this.getSubscriptions( );
            },
            
            do_delete( id ){

              this.showSuccess( null );

              this.getDeleteSubscription( id );

              this.setShow( 'delete' );

            },
            
            do_edit( id ){

              this.showSuccess( null );

              this.getSubscription( id );

              this.setShow( 'edit' );
            }
        }
    }
</script>

<style>
.datepicker_bill_date{
  width: 160px !important;
}
</style>
