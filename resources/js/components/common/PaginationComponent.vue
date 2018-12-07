<template>
    <div v-if="pagination.last_page > 1" aria-label="Page navigation example">
	  <ul class="pagination">
	    <li :class="{'page-item' : true, 'disabled':!pagination.prev_page_url }"><a @click="load_page( pagination.current_page - 1 )" class="page-link" href="javascript: void( 0 );" :disabled="!pagination.prev_page_url">Previous</a></li>
	    <li v-for="n in pagination.last_page" :class="{'page-item':true, 'active': n == pagination.current_page}"><a @click="load_page( n )" class="page-link" href="javascript: void( 0 );">{{n}}</a></li>
	    <li :class="{'page-item' : true, 'disabled':!pagination.next_page_url }"><a @click="load_page( pagination.current_page + 1 )" class="page-link" href="javascript: void( 0 );" :disabled="!pagination.next_page_url">Next</a></li>
	  </ul>
	</div>
</template>

<script>

import { mapState, mapActions } from 'vuex';

    export default {
        data(){
            return{

            }
        },
        mounted( ){

        },
        computed:{
             ...mapState( [ 'page_data' ] ),

             pagination(  ){
             	return this.page_data.pagination;
             }
           
        },
        methods : {
            ...mapActions( [ 'setShow', 'setModal', 'getCustomers' ] ),

            load_page( page ){
            	if( page > 0 && page <= this.pagination.last_page && page != this.pagination.current_page )
            		this.getCustomers( { page : page } );
            }
        }
    }
</script>

<style>

</style>
