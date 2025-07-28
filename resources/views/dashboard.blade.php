<!DOCTYPE html>
<html lang="en" x-data="userDashboard()" x-init="init()">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">
  <div class="w-full max-w-4xl">
    <h1 class="text-3xl font-bold text-center mb-6">👥 User Dashboard</h1>
    <div class="flex justify-end mb-4">
      <button @click="openCreate()" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">➕ New User</button>
    </div>
    <table class="table-auto w-full bg-white shadow rounded">
      <thead class="bg-indigo-600 text-white">
        <tr>
          <th class="px-4 py-2">ID</th>
          <th class="px-4 py-2">Name</th>
          <th class="px-4 py-2">Email</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <template x-for="usr in users" :key="usr.id">
          <tr class="border-t">
            <td class="px-4 py-2" x-text="usr.id"></td>
            <td class="px-4 py-2" x-text="usr.nombre"></td>
            <td class="px-4 py-2" x-text="usr.email"></td>
            <td class="px-4 py-2">
              <button @click="openEdit(usr)" class="text-blue-600 mr-2">✏️</button>
              <button @click="remove(usr.id)" class="text-red-600">🗑️</button>
            </td>
          </tr>
        </template>
        <tr x-show="users.length===0">
          <td colspan="4" class="text-center p-4">No users</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div x-show="showModal" class="fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-lg w-80" @click.outside="closeModal()">
      <h2 class="text-xl font-semibold mb-4" x-text="editMode ? 'Edit User' : 'New User'"></h2>
      <form @submit.prevent="submit">
        <div class="mb-3">
          <label class="block mb-1 text-sm">Name</label>
          <input type="text" x-model="form.nombre" class="w-full border px-3 py-2 rounded" required />
        </div>
        <div class="mb-3">
          <label class="block mb-1 text-sm">Email</label>
          <input type="email" x-model="form.email" class="w-full border px-3 py-2 rounded" required />
        </div>
        <div class="flex justify-end">
          <button type="button" class="mr-2 px-3 py-2" @click="closeModal()">Cancel</button>
          <button type="submit" class="px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500">Save</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function userDashboard(){
      return{
        baseUrl:'http://localhost:8000/api/',
        users:[],
        showModal:false,
        editMode:false,
        form:{id:null, nombre:'', email:''},
        init(){
          this.fetchUsers();
        },
        fetchUsers(){
          fetch(this.baseUrl+'list').then(r=>r.json()).then(d=>{this.users=d.usuarios;});
        },
        openCreate(){
          this.editMode=false;
          this.form={id:null,nombre:'',email:''};
          this.showModal=true;
        },
        openEdit(u){
          this.editMode=true;
          this.form={...u};
          this.showModal=true;
        },
        closeModal(){
          this.showModal=false;
        },
        submit(){
          if(this.editMode){ this.updateUser(); } else { this.createUser(); }
        },
        createUser(){
          fetch(this.baseUrl+'create',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(this.form)}).then(r=>r.json()).then(()=>{this.fetchUsers();this.closeModal();});
        },
        updateUser(){
          fetch(this.baseUrl+'edit/'+this.form.id,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(this.form)}).then(r=>r.json()).then(()=>{this.fetchUsers();this.closeModal();});
        },
        remove(id){
          if(!confirm('Delete user?')) return;
          fetch(this.baseUrl+'delete/'+id,{method:'DELETE'}).then(()=>{this.fetchUsers();});
        }
      }
    }
  </script>
</body>
</html>
