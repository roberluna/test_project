<template>
	<v-app>
		<!-- <v-navigation-drawer app> </v-navigation-drawer> -->
		<v-app-bar app>
			<v-app-bar-nav-icon></v-app-bar-nav-icon>

			<v-toolbar-title>Application</v-toolbar-title>
		</v-app-bar>
		<v-main>
			<v-container>
				Content Here
				<!-- If using vue-router -->
				<!-- <router-view></router-view> -->
			</v-container>
		</v-main>
	</v-app>
</template>

<script setup></script>

<style>
.v-application {
	font-family: 'Poppins', sans-serif;
	line-height: 1;
}
</style>
