<script setup>
  import { ref, onMounted, onBeforeMount } from "vue";
  import axios from "axios";

  import { useToast } from "primevue/usetoast";
  import { inject } from "vue";

  const action = ref("");
  let ProExp = inject("eduData");

  const educationDialog = ref(false);
  const confirmRequestVar = ref(false);

  const educations = ref([]);
  let id = ref(0);
  const education_req = ref({
    title: "",
    start_date: "",
    end_date: "",
    type: "",
    description: "",
  });

  onMounted(() => {
    axios.get("/api/educations").then((response) => {
      educations.value = response.data.data;
    });
  });

  const display = ref(false);
  const description = ref("");
  const open = (description_text) => {
    description.value = description_text;
    display.value = true;
  };

  const education = ref({
    title: "",
    description: "",
  });
  const close = () => {
    education.value = {};
    display.value = false;
  };

  const confirmDeleteeducation = () => {
    action.value = "delete";
    confirmRequestVar.value = true;
  };

  const openNew = () => {
    action.value = "add";
    education.value = {};
    educationDialog.value = true;
  };
  const modifyeducationRequest = () => {
    if (action.value == "delete") {
      ProExp.value.splice(id.value, 1);
    } else if (action.value == "add") {
      ProExp.value.push(education_req.value);
    }
  };
  const formattedDate = (startDate) => {
    const originalDate = new Date(startDate);

    return originalDate.toLocaleDateString("en-GB", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
    });
  };
</script>

<template>
  <div class="col-12 xl:col-12">
    <div class="card flex flex-column">
      <div class="flex justify-content-between align-items-center mb-5">
        <h5>Educations</h5>
        <div>
          <Button
            label="New"
            icon="pi pi-plus"
            class="p-button-success mr-2"
            @click="openNew"
          />
          <Menu ref="menu2" :popup="true" :model="items"></Menu>
        </div>
      </div>

      <ul
        v-if="ProExp.length > 0"
        class="list-none p-0 m-0"
        v-for="(item, index) in ProExp"
        :key="index"
      >
        <li
          class="flex flex-column md:flex-row md:align-items-center md:justify-content-between mb-4"
        >
          <div>
            <span class="text-900 font-medium mr-2 mb-1 md:mb-0">{{
              item.title
            }}</span>
            <div class="mt-1 text-600">
              {{ formattedDate(item.start_date) }} -
              {{ formattedDate(item.end_date) }}
            </div>
          </div>

          <span class="text-orange-500 ml-3 font-medium">
            <Button
              icon="pi pi-eye"
              class="p-button p-button-primary mr-2"
              @click="
                () => {
                  education = item;
                  open();
                }
              "
            />

            <Button
              icon="pi pi-trash"
              class="p-button p-button-danger mt-2"
              @click="
                () => {
                  id = index;
                  education = item;
                  confirmDeleteeducation();
                }
              "
            />
          </span>
        </li>
      </ul>
    </div>
  </div>

  <Dialog
    :header="education.title"
    v-model:visible="display"
    :breakpoints="{ '960px': '75vw' }"
    :style="{ width: '30vw' }"
    :modal="true"
  >
    <p class="line-height-3 mb-3">{{ education.description }}</p>

    <Button
      label="Ok"
      @click="close"
      icon="pi pi-check"
      class="p-button-outlined mt-2"
    />
  </Dialog>
  <Dialog
    v-model:visible="educationDialog"
    :style="{ width: '450px' }"
    header="Education item"
    :modal="true"
    class="p-fluid"
  >
    <div class="formgrid grid">
      <div class="field col">
        <label for="quantity">Title</label>
        <InputText type="text" v-model="education_req.title"></InputText>
      </div>
    </div>
    <div class="formgrid grid">
      <div class="field col mt-4">
        <span class="p-float-label">
          <Calendar
            inputId="calendar"
            v-model="education_req.start_date"
          ></Calendar>
          <label for="calendar">Start Day</label>
        </span>
      </div>

      <div class="field col mt-4">
        <span class="p-float-label">
          <Calendar
            inputId="calendar"
            v-model="education_req.end_date"
          ></Calendar>
          <label for="calendar">End Day</label>
        </span>
      </div>
    </div>

    <div class="field">
      <label for="name">Description</label>
      <Textarea v-model="education_req.description" />
    </div>
    <template #footer>
      <Button
        label="Cancel"
        icon="pi pi-times"
        class="p-button-text"
        @click="hideDialog"
      />
      <Button
        label="Save"
        icon="pi pi-check"
        class="p-button-text"
        @click="
          () => {
            confirmRequestVar = true;
            educationDialog = false;
          }
        "
      />
    </template>
  </Dialog>
  <Dialog
    v-model:visible="confirmRequestVar"
    :style="{ width: '500px' }"
    header="Confirm"
    :modal="true"
  >
    <div class="flex align-items-center justify-content-center">
      <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
      <span v-if="education"
        >Are you sure you want to {{ action }} the education?</span
      >
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        class="p-button-text"
        @click="
          () => {
            confirmRequestVar = false;
          }
        "
      />
      <Button
        label="Yes"
        icon="pi pi-check"
        class="p-button-text"
        @click="
          () => {
            confirmRequestVar = false;
            educationDialog = false;

            modifyeducationRequest();
            education_req = {};
          }
        "
      />
    </template>
  </Dialog>
</template>

<style scoped lang="scss">
  @import "@/assets/demo/styles/badges.scss";
</style>
