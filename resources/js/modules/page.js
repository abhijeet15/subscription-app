
export default {

	state: {
    show: js_parent_var.page, // -- view currently to be shown "idx-page-edit[ listing | edit | status | delete ]"
	},

	getters: {

	},

	actions: {

    setShow( context, show )
    {
      // Now set the new page show
      context.commit( 'SET_SHOW', show );
    }


	},

	mutations: {

    SET_SHOW ( state, show )
    {
      state.show = show;
    }

	}
}
