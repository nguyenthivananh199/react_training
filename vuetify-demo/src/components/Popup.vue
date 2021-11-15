<template>
  <div class="text-center">
    <v-dialog width="500">
      <template v-slot:activator="{ on }">
        <v-btn class="success" dark v-on="on">Add New Project</v-btn>
      </template>
      <v-card>
        <v-card-title>
          <h2>Add a New Project</h2>
        </v-card-title>
        <v-card-text>
          <v-form class="px-3">
            <v-text-field
              v-model="title"
              label="Title"
              prepend-icon="folder"
            ></v-text-field>
            <v-textarea
              v-model="content"
              label="Information"
              prepend-icon="edit"
            ></v-textarea>
            <v-menu max-width="290">
              <template v-slot:activator="{ on }">
                <v-text-field
                  :value="formattedDate"
                  label="Due date"
                  prepend-icon="mdi-calendar-range"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker v-model="due"></v-date-picker>
            </v-menu>
            <v-spacer></v-spacer>
            <v-btn text @click="submit" class="success mx-0 mt-3"
              >Add Project1</v-btn 
            >
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import format from 'date-fns/format'
import parseISO from 'date-fns/parseISO'
export default {
  data() {
    return {
      title: "",
      content: "",
      due:null,
    };
  },
  methods: {
    submit() {
      console.log(this.title, this.content);
    },
  },
  computed: {
   formattedDate(){
    return this.due ? format(parseISO(this.due), 'do MMM yyyy') : ''
   },
   
  }
};
</script>

<style></style>
