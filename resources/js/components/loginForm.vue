<template>
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">Adresse Email:</label>
    <input type="email" class="form-control" v-model="email" id="exampleInputEmail1" aria-describedby="emailHelp">

  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe:</label>
    <input type="password" class="form-control" v-model="password" id="exampleInputPassword1">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" @click="login"    class="btn btn-primary">Submit</button>
</form>
</template>
<script>
export default{
    data:()=>({

          email:"",
          password:""

}),
methods: {
           login(){
   axios.post('/api/login',{
    email:this.email,
    password:this.password
   }).then(response=>{
window.location.replace("/home");
console.log(response)
   }).catch(error=>{
       console.log(error);
   })

           }
   // this.$store.dispatch('currentUser/loginUser',this.user);
}
}




</script>
