import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        message: {
            snackbar: false,
            description: "",
            color: "",
        },
        pagination: {
			current: 1,
			total: 0
		},
    },
    mutations: {
        showMessage(state, message) {
            state.message.snackbar = message.snackbar;
            state.message.description = message.description;
            state.message.color = message.color;
        },
        hideMessage(state) {
            state.message.snackbar = false;
        },
        setPageState(state, pagination) {
            state.pagination.current = pagination.current;
            state.pagination.total = pagination.total;
        },
    },
    plugins: [createPersistedState()]
})
