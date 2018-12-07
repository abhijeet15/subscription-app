
export default {

	state: {
    collection: [ ],
    model: {},
    filters:{},
    sql:null,
    pagination:[ ],
    error_msg: [],
    success_msg: null

	},

	getters: {

	},

	actions: {

    updateSubscriptionCollection( { context, state },params ){


      let x = _.findKey( this.state.page_data.collection, function(  o ) { return ( o.id == params.id ) })

      // -- insert new data
      if( typeof x == "undefined" || parseInt( x ) < 0 )
        x = this.state.page_data.collection.length
      
      Vue.set( this.state.page_data.collection, x, params.data );
      
    },

    deleteSubscriptionCollection( { context, state }, id ){


      let x = _.findKey( this.state.page_data.collection, function(  o ) { return ( o.id == id ) })

      Vue.delete( this.state.page_data.collection, x );
      
    },

    getDeleteSubscription( { commit, state }, id ){
        let x = _.filter( this.state.page_data.collection, function(o) { return ( o.id == id ); });
        if( x.length > 0 )
          commit( 'UPDATE_SUBSCRIPTION_MODEL', x[ 0 ] );
        else
        {
          commit( 'UPDATE_SUBSCRIPTION_MODEL', { } );
        }

    },

    getSubscriptions( context, params )
    {
      let url = "" ;
      //if( params.length > 0 )
      {
        for (var key in params) {
            if (url != "") {
                url += "&";
            }
            url += key + "=" + encodeURIComponent(params[key]);
        }
      }

      axios
        .get( js_parent_var.api_base_url + "/subscriber/list" )
            .then(
                (response)  =>  {
                  
                  //if( response.status == 200 )
                    context.commit( 'UPDATE_CUSTOMERS', response.data );


                    let pagination_param = {};
                    pagination_param.current_page = response.data.current_page;
                    pagination_param.first_page_url = response.data.first_page_url;
                    pagination_param.from = response.data.from;
                    pagination_param.to = response.data.to;
                    pagination_param.last_page_url = response.data.last_page_url;
                    pagination_param.last_page = response.data.last_page;
                    pagination_param.next_page_url = response.data.next_page_url;
                    pagination_param.path = response.data.path;
                    pagination_param.per_page = response.data.per_page;
                    pagination_param.prev_page_url = response.data.prev_page_url;
                    pagination_param.total = response.data.total;


                    context.commit( 'UPDATE_SQL', response.data.sql );
                    context.commit( 'UPDATE_PAGINATION', pagination_param );
                    context.commit( 'UPDATE_FILTERS', response.data.filters );
                    
                }, 
                (error)  =>  {
                    //this.loading = false;
                    context.commit( 'UPDATE_SQL', null );
                    context.commit( 'UPDATE_CUSTOMERS', { } );
                    context.commit( 'UPDATE_PAGINATION', 0 );
                    context.commit( 'UPDATE_FILTERS', { } );
                }
            );
    },

    getSubscription( context, id )
    {
      if( id )
      {
        axios
        .get( js_parent_var.api_base_url + "/subscriber/" + id )
            .then(
                (response)  =>  {
                  
                  //if( response.status == 200 )
                    context.commit( 'UPDATE_SUBSCRIPTION_MODEL', response.data );

                }, 
                (error)  =>  {
                    //this.loading = false;
                    context.commit( 'UPDATE_SUBSCRIPTION_MODEL', { } );
                }
            );
      }
      else
        context.commit( 'UPDATE_SUBSCRIPTION_MODEL', { } );

    },

    set_model(context,params){
      context.commit( 'UPDATE_SUBSCRIPTION_MODEL', params );
    },

    subscribe( { context, dispatch }, params )
    {
        var ajaxMethod = "post";
        var url = js_parent_var.api_base_url + "/subscriber";
        if( parseInt( params.id ) > 0 ){
          url += "/" + params.id;
          var ajaxMethod = "patch";
        }

        dispatch( 'showError', [] );

        return new Promise( function( resolve, reject ){
          axios[ ajaxMethod ]( url, params )
              .then(
                  (response)  =>  {
                    
                    dispatch( 'set_model', {} );

                    if( params.id ){
                      dispatch( 'updateSubscriptionCollection', { id: params.id, data: response.data } )
                    }

                    
                    resolve( response );

                  }, 
                  (error)  =>  {
                      reject( error );
                  }
              );
        } );
        
    },

    deleteSubscription( { context, dispatch }, id )
    {
        return new Promise( function( resolve, reject ){
          axios
          .delete( js_parent_var.api_base_url + "/subscriber/" + id, { } )
              .then(
                  (response)  =>  {
                     resolve( response );
                     dispatch( 'deleteSubscriptionCollection', id );
                  }, 
                  (error)  =>  {
                      reject( error );
                  }
              );
        } );
        
    },

    showError( context, msg )
    {
        context.commit( 'UPDATE_ERROR_MSG', msg );
        context.commit( 'UPDATE_SUCCESS_MSG', null );
        // setTimeout( function() { context.commit( 'UPDATE_ERROR_MSG', { } ) }, 6000 );
    },

    showSuccess( context, msg )
    {
        context.commit( 'UPDATE_SUCCESS_MSG', msg );
        context.commit( 'UPDATE_ERROR_MSG', {} );

        setTimeout( function() { context.commit( 'UPDATE_SUCCESS_MSG', null ) }, 6000 );
    }


	},

	mutations: {

    UPDATE_CUSTOMERS(state, payload) {

      state.collection = payload.data;
    
    },

    UPDATE_PAGINATION(state, payload) {

      state.pagination = payload;
     
    },

    UPDATE_SQL(state, payload) {

      state.sql = payload;
     
    },

    UPDATE_FILTERS(state, payload) {

      state.filters = payload;
     
    },

    UPDATE_SUBSCRIPTION_MODEL_ERRORS(state, payload) {

      state.pamodel_errorsgination = payload;
     
    },

    UPDATE_SUBSCRIPTION_MODEL(state, payload) {
      alert("in!!!");
      state.model = payload;
     
    
    },

    UPDATE_ERROR_MSG(state, payload) {
      state.error_msg = payload;
     
    
    },

    UPDATE_SUCCESS_MSG(state, payload) {
      state.success_msg = payload;
    }
	}
}
