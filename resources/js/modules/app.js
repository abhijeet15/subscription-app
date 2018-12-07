
export default {

	state: {
    error_msg: [],
	},

	getters: {

	},

	actions: {

    login( { context, dispatch }, params )
    {

        var url = js_parent_var.api_base_url + "/login";
        dispatch( 'showError', [] );


        return new Promise( function( resolve, reject ){
          axios
          .post( url, params )
              .then(
                  (response)  =>  {
                    resolve( response );
                  }, 
                  (error)  =>  {
                      reject( error );
                  }
              );
        } );
        
    },

    register( { context, dispatch }, params )
    {

        var url = js_parent_var.api_base_url + "/register";
        dispatch( 'showError', [] );


        return new Promise( function( resolve, reject ){
          axios
          .post( url, params )
              .then(
                  (response)  =>  {
                    resolve( response );
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
        setTimeout( function() { context.commit( 'UPDATE_ERROR_MSG', { } ) }, 6000 );
    }


	},

	mutations: {

    UPDATE_ERROR_MSG(state, payload) {
      state.error_msg = payload;
     
    
    }
	}
}
