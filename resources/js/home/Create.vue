<template>
	<v-container>
		<v-form @submit.prevent="store()">
			<v-container>
				<v-row>
					<v-col cols="12">
						<v-text-field v-model="user.first_name" label="First name" required></v-text-field>
					</v-col>
					<v-col cols="12">
						<v-text-field v-model="user.last_name" label="Last name" required></v-text-field>
					</v-col>
					<v-col cols="12">
						<v-text-field v-model="user.email" :rules="emailRules"  required label="Email"></v-text-field>
					</v-col>
				</v-row>
			</v-container>
			<v-card-actions>
				<v-spacer></v-spacer>
				<v-btn type="submit" color="blue darken-1" text>Save</v-btn>
			</v-card-actions>
		</v-form>
	</v-container>	
</template>

<script>
import { mapMutations } from "vuex";
export default {
	name:"Create",
	data: () => ({
		user: {
			last_name: "",
			first_name: "",
			email: "",
      },
	    emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid',
      ],
	}),
	methods: {
		...mapMutations(["showMessage"]),
		async store() {
			await axios
				.post("/users/store", this.user)
				.then((res) => {

					const message = {
						snackbar: true,
						description: `User created`,
						color: "success",
					};
					this.showMessage(message);
					this.$router.push({
							name: "home",
					});
				})
				.catch((error) => {
					console.log(error);
				});
		},
	}
  };
</script>

<style>
.v-application {
	font-family: 'Poppins', sans-serif;
	line-height: 1;
}
</style>
