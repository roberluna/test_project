<template>
<v-container>

    <v-row class="pa-4">
        <v-spacer></v-spacer>
        <v-btn tile color="success" to="/user/create">
        <v-icon left>mdi-plus</v-icon>Add user</v-btn>
    </v-row>

    <v-row>
        <v-chip class="ma-2" color="primary">{{total}} Users</v-chip>
        <v-spacer></v-spacer>
        <v-pagination
                            v-model="pagination.current"
                            :length="pagination.total"
                            @input="onPageChange"
        ></v-pagination>
    </v-row>
				  <v-simple-table>
					<template v-slot:default>
					<thead>
						<tr>
							<th class="text-left">
								Last name
							</th>
							<th class="text-left">
								First name
							</th>
							<th class="text-left">
								Email
							</th>
							<th class="text-left">
								Options
							</th>
						</tr>
					</thead>
					<tbody>
						<tr
						v-for="user in users"
						:key="user.id"
						>
							<td>{{ user.last_name }}</td>
							<td>{{ user.first_name }}</td>
							<td>{{ user.email }}</td>
							<td>
								 <v-btn  x-small @click="edit(user.id)"><v-icon left>mdi-pencil</v-icon>Edit</v-btn>
								 <v-btn  x-small
								  		@click="deleteUser(user)"
								 ><v-icon left>mdi-delete</v-icon>Delete</v-btn>
							</td>
						</tr>
					</tbody>
					</template>
				</v-simple-table>

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
	name:"Users",
		data: () => ({
		users: [],
		total: 0,
		pagination: {
			current: 1,
			total: 0
		},
		statusRequest: false,
		dialogLoading: true,
		dialogLoadingMsg:'Loading users...'
    }),
	computed: {
        loading () {
            if(this.statusRequest == false){
				 	this.dialogLoading = true;
                    this.dialogLoadingMsg = "Loading users..."; 
            }
			else {
				this.dialogLoading = false;
				this.statusRequest = false;
				this.dialogLoadingMsg = "";
            }
        }
    },
	created() {
		this.getUsers();
    },
	methods: {
		...mapMutations(["showMessage"]),
		async getUsers(page=1) {
				await axios
					.get(`/users?page=${this.pagination.current}`)
					.then(res => {
						this.dialogLoadingMsg ='Loading users...';
						this.dialogLoading = false;
						this.users = res.data.data;
						this.total = res.data.total;
						this.pagination.current = res.data.current_page;
                    	this.pagination.total = res.data.last_page;
						this.statusRequest =  res.status;

					})
					.catch(function (error) {
						console.log(error);
					});
			},
		
		async deleteUser(user) {
					await axios.post('/users/destroy', user) 
					.then(res => {
						const message = {
							snackbar: true,
							description: `User deleted`,
							color: "success",
						};
						this.showMessage(message);
						this.getUsers();
					})
					.catch(function (error) {
						console.log(error);
					});
        },
		edit(id) {
			this.$router.push({ name: "user.edit", params: { id: id } });
		},
		onPageChange() {
            this.getUsers();
        }
	}
  };
</script>

<style>
.v-application {
	font-family: 'Poppins', sans-serif;
	line-height: 1;
}
</style>
