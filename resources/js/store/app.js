import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

import page_data from './../modules/app';

export const store = new Vuex.Store({
	modules:{
		page_data,
	},
	state : {		
		app		: js_parent_var.app,
		base_url: js_parent_var.base_url,
		csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	}
});