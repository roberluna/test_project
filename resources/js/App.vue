<template>
	<v-app>
		<!-- <v-navigation-drawer app> </v-navigation-drawer> -->
		<v-app-bar app>
			<v-app-bar-nav-icon></v-app-bar-nav-icon>
			<v-toolbar-title></v-toolbar-title>
		</v-app-bar>
		<v-main>
			<v-container>
				<!-- If using vue-router -->
				 <router-view></router-view>
			</v-container>
			  <v-snackbar v-model="message.snackbar" :color="message.color">
          			{{ message.description }}
            		<template v-slot:action="{ attrs }">
						<v-btn
						text
						v-bind="attrs"
						@click="hideMessage"
						>
							Close
              			</v-btn>
          		</template>
      		</v-snackbar>
		</v-main>
	</v-app>
</template>

<script>

import {mapState, mapMutations} from 'vuex'
export default {
    computed: {
    ...mapState(['message']),
  },
  methods: {
    ...mapMutations(['hideMessage']),
  }
};
</script>

<style>
.v-application {
	font-family: 'Poppins', sans-serif;
	line-height: 1;
}
</style>
