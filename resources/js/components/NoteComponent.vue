<template>

    <div class="field" >
        
        <div class="  p-3 mb-5  has-background-warning	box" >
             <div class=" has-text-warning" v-show="noteform">
              
                 <input type="text" ref="NoteTitle" class="input is-warning " placeholder="Title"> <br>

            </div>  
        <br>
            <div class=" has-text-warning">
                
                <textarea ref="NoteBody" class="textarea is-warning"  rows="1" @click="createnote"  @keydown="ExpandTextArea()" placeholder="Take a note"></textarea>
                <!-- <input type="text" class="form-control" placeholder="title" > -->
            </div>
            <div class="image-upload" v-show="noteform">
                <label for="file-input">
                    <i class="fas fa-camera fa-2x"></i>
                </label>

                <input id="file-input" type="file"/>
            </div>
<br>
           <button class="btn btn-warning" v-show="noteform" @click="storenote()">Close</button>
                 
        </div> <br>
        <div class="container " >
           <div class="row columns">
                <div class="column is-3" 
                    v-for="note in notes" :key='note.id'>
                  <div class='has-background-warning box box-shadow'>
                       <strong class='title is-5' type=''>{{note.title}}</strong>
                        <p class='content is-small' style="white-space: pre;">{{ note.note }}</p>
                  </div>
               </div>
            </div>
        </div>


     



    </div>
</template>
<script>
export default {
    data(){
        return {
            noteform: false,
            textrow: 2,
            notes: [],

        }
    },
    methods:{
        createnote(){
            this.noteform=true;
            this.notedisplay=true;
        },
        ExpandTextArea() {
            var el = this.$refs.NoteBody;
            el.style.overflow = 'hidden';
            el.style.height = 0;
            el.style.height = el.scrollHeight + 'px';       
        },
        shownote(){
            axios.get('/note/show').then((response)=>{
                this.notes = response.data
            })
        },
        storenote(){
            if( this.$refs.NoteTitle.value== '' &  this.$refs.NoteBody.value == '')
            {
                  this.noteform=false;
                this.shownote();
            }
            else{
                axios.post('/storenote',{
                    title: this.$refs.NoteTitle.value,
                    note: this.$refs.NoteBody.value,
                }).then(
                    this.$refs.NoteTitle.value='',
                    this.$refs.NoteBody.value='',
                    this.noteform=false,
                    this.shownote(),
                )
            }
            
            
        }
    },
    mounted() {
        this.shownote();
    }
}
</script>
