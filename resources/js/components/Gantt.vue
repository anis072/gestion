<template>
 <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                   <div class="card-body">

                    <div id="gantt_here">

                     </div>

                    </div>

             </div>
            </div>
        </div>
    </div>

</template>

<script>

    export default {

        data(){
            return{
                   key: this.$route.params.id,


            }
        },
        created(){

    gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
    gantt.config.order_branch = true;/*!*/
    gantt.config.order_branch_free = true;/*!*/
    gantt.init("gantt_here");

    gantt.load("/api/data/"+this.key);

    var dp = new gantt.dataProcessor("/api");/*!*/
    dp.init(gantt);/*!*/
    dp.setTransactionMode("REST");/*!*/

        },
        mounted() {

                console.log('Component mounted.')
        }
    }
</script>
<style scoped>
/**.gantt-chart{
    margin-left: 9%;
    position: left;
    width: 92%;
    height: 600px;
}

*{
    margin:0;
    padding:0;
  }
  body{
    font-family:arial,sans-serif;
    font-size:100%;
    margin:3em;
    background:#666;
    color:#fff;
  }*/


</style>
