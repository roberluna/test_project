<template>
	<v-container>
			<v-form @submit.prevent="update()">
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

				<v-dialog v-model="dialogLoading" hide-overlay persistent width="300">
            <v-card color="primary" dark>
                <v-card-text>
                    {{ dialogLoadingMsg }}
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
	</v-container>	
</template>

<script>
import { mapMutations } from "vuex";
export default {
	name:"Edit",
	data: () => ({
		user: [],
	    emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid',
      ],
	}),
	computed: {
        loading () {
            if(this.statusRequest == false){
				 	this.dialogLoading = true;
                    this.dialogLoadingMsg = "Loading user..."; 
            }
			else {
				this.dialogLoading = false;
				this.statusRequest = false;
				this.dialogLoadingMsg = "";
            }
        }
    },
    created() {
		this.getUser();
    },
	methods: {
		...mapMutations(["showMessage"]),
        async getUser() {
            let url = `/users/show/${this.$route.params.id}`;
            await axios.get(url).then((res) => {
                this.user = res.data;
				this.statusRequest =  res.status;
            });
         },
         async update() {
                await axios
                .post("/users/update/", this.user)
                .then((res) => {
					const message = {
						snackbar: true,
						description: `User updated`,
						color: "success",
					};
					this.showMessage(message);
                    this.$router.push({
                        name: "home",
                    });
                })
                .catch((error) => {
                    console.log("error");
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
