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
								Created
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
							<td>{{ user.created_at }}</td>
							<td>
								 <v-btn  x-small @click="edit(user)"><v-icon left>mdi-pencil</v-icon>Edit</v-btn>
								 <v-btn  x-small
								  		@click="userSelected = user; dialogDelete=true;"
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

		<v-row justify="center">
    <v-dialog
      v-model="dialogEdit"
      persistent
      max-width="600px"
    >  
	<v-form @submit.prevent="update()">
      <v-card>
        <v-card-title>
          <span class="text-h5">User update</span>
        </v-card-title>
        <v-card-text>
          <v-container>
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
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialogEdit = false"
          >
            Close
          </v-btn>
          <v-btn
		    type="submit"
            color="blue darken-1"
            text
            @click="dialogEdit = false"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
	</v-form>
    </v-dialog>


	<v-dialog
      v-model="dialogDelete"
      persistent
      max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          Delete User
        </v-card-title>
        <v-card-text>Are you sure to delete this user??</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            text
            @click="dialogDelete = false"
          >
            Disagree
          </v-btn>
          <v-btn
            color="green darken-1"
            text
            @click="deleteUser(userSelected)"
          >
            Agree
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</v-container>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
  export default {
	name:"Users",
		data: () => ({
		users: [],
		user: [],
		userSelected: [],
		emailRules: [
			v => !!v || 'E-mail is required',
			v => /.+@.+/.test(v) || 'E-mail must be valid',
		],
		total: 0,
		statusRequest: false,
		dialogLoading: true,
		dialogLoadingMsg:'Loading users...',
		dialogEdit: false,
		dialogDelete: false,
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
        },
		...mapState(['pagination'])
    },
	created() {
		this.getUsers();
    },
	methods: {
		...mapMutations(["showMessage"]),
		...mapMutations(["setPageState"]),
		async getUsers() {
				await axios
					.get(`/users?page=${this.pagination.current}`)
					.then(res => {
						this.dialogLoadingMsg ='Loading users...';
						this.dialogLoading = false;
						this.users = res.data.data;
						this.total = res.data.total;
						this.pagination.current = res.data.current_page;
                    	this.pagination.total = res.data.last_page;
						const page = {
							current: res.data.current_page,
							total: res.data.last_page
						};
						this.setPageState(page);
                		this.showMessage(setPageState);
						this.statusRequest =  res.status;
						
					})
					.catch(function (error) {
						console.log(error);
					});
			},
		
		async deleteUser(user) {
			if(this.dialogDelete){
					await axios.post('/users/destroy', user) 
					.then(res => {
						this.dialogDelete=false;
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
			}		
        },
		edit(user) {
			this.user = user;
			this.dialogEdit =  true;
		},
		   async update() {
                await axios
                .post("/users/update/", this.user)
                .then((res) => {
					this.getUsers()
					this.dialogEdit = false
					const message = {
						snackbar: true,
						description: `User updated`,
						color: "success",
					};
					this.showMessage(message);
                })
                .catch((error) => {
                    console.log("error");
                });
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
