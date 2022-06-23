<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Crud base</div>

                    <div class="card-body">
                        <div class="container container-task">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table text-center"><!--Creamos una tabla que mostrará todas las tareas-->
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Apellido</th>
                                                    <th scope="col">Correo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="task in arrayTasks" :key="task.id"> <!--Recorremos el array y cargamos nuestra tabla-->
                                                    <td v-text="task.firstname"></td>
                                                    <td v-text="task.lastname"></td>
                                                    <td v-text="task.email"></td>
                                                    <td>
                                                        <!--Botón modificar, que carga los datos del formulario con la tarea seleccionada-->
                                                        <button class="btn  btn-primary" @click="loadFieldsUpdate(task)">Modificar</button>
                                                        <!--Botón que borra la tarea que seleccionemos-->
                                                        <button class="btn btn-secondary" @click="deleteTask(task)">Borrar</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"><!-- Formulario para la creación o modificación de nuestras tareas-->
                                        <label>Nombre</label>
                                        <input v-model="firstname" type="text" class="form-control">

                                        <label>Apellido</label>
                                        <input v-model="lastname" type="text" class="form-control">

                                        <label>correo</label>
                                        <input v-model="email" type="email" class="form-control">
                                    </div>
                                    <div class="container-buttons">
                                        <br>
                                        <!-- Botón que añade los datos del formulario, solo se muestra si la variable update es igual a 0-->
                                        <button v-if="update == 0" @click="saveTasks()" class="btn btn-success">Añadir</button>
                                        <!-- Botón que modifica la tarea que anteriormente hemos seleccionado, solo se muestra si la variable update es diferente a 0-->
                                        <button v-if="update != 0" @click="updateTasks()" class="btn btn-warning">Actualizar</button>
                                        <!-- Botón que limpia el formulario y inicializa la variable a 0, solo se muestra si la variable update es diferente a 0-->
                                        <button v-if="update != 0" @click="clearFields()" class="btn">Atrás</button>
                                    </div>
                                </div>
                            </div>
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
                firstname:"", //Esta variable, mediante v-model esta relacionada con el input del formulario
                lastname:"", //Esta variable, mediante v-model esta relacionada con el input del formulario
                email:"", //Esta variable, mediante v-model esta relacionada con el input del formulario
                update:0, /*Esta variable contrarolará cuando es una nueva tarea o una modificación, si es 0 significará que no hemos seleccionado
                          ninguna tarea, pero si es diferente de 0 entonces tendrá el id de la tarea y no mostrará el boton guardar sino el modificar*/
                arrayTasks:[], //Este array contendrá las tareas de nuestra bd
            }
        },
        methods:{
            getTasks(){
                let me =this;
                let url = '/api/base' //Ruta que hemos creado para que nos devuelva todas las tareas
                axios.get(url).then(function (response) {
                    //creamos un array y guardamos el contenido que nos devuelve el response
                    me.arrayTasks = response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            saveTasks(){
                let me =this;
                let url = '/api/base' //Ruta que hemos creado para enviar una tarea y guardarla
                axios.post(url,{ //estas variables son las que enviaremos para que crear la tarea
                    'firstname':this.firstname,
                    'lastname':this.lastname,
                    'email':this.email,
                }).then(function (response) {
                    me.getTasks();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                    me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });   

            },
            updateTasks(){/*Esta funcion, es igual que la anterior, solo que tambien envia la variable update que contiene el id de la
                tarea que queremos modificar*/
                let me = this;
                axios.put('/api/base/'+this.update,{
                    'id':this.update,
                    'firstname':this.firstname,
                    'lastname':this.lastname,
                    'email':this.email,
                }).then(function (response) {
                   me.getTasks();//llamamos al metodo getTask(); para que refresque nuestro array y muestro los nuevos datos
                   me.clearFields();//Limpiamos los campos e inicializamos la variable update a 0
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadFieldsUpdate(data){ //Esta función rellena los campos y la variable update, con la tarea que queremos modificar
                this.update = data.id
                let me =this;
                let url = '/api/base/'+this.update;
                axios.get(url).then(function (response) {
                    me.firstname= response.data.firstname;
                    me.lastname= response.data.lastname;
                    me.email= response.data.email;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                }); 
            },
            deleteTask(data){//Esta nos abrirá un alert de javascript y si aceptamos borrará la tarea que hemos elegido
                let me =this;
                let task_id = data.id
                if (confirm('¿Seguro que deseas borrar esta tarea?')) {
                    axios.delete('/api/base/'+task_id
                    ).then(function (response) {
                        me.getTasks();
                    })
                    .catch(function (error) {
                        console.log(error);
                    }); 
                }
            },
            clearFields(){/*Limpia los campos e inicializa la variable update a 0*/
                this.firstname = "";
                this.lastname = "";
                this.content = "";
                this.email = 0;
            }
        },
        mounted() {
           this.getTasks();
        }
    }
</script>