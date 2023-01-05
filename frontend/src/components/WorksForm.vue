<template>
  <form
    action="#"
    class="work-form"
    enctype="multipart/form-data"
    @submit.prevent="saveWork"
    ref="workForm"
  >
    <div class="work-form__field work-form__field--input">
      <BaseInput name="title" v-model="work.title" plcHolder="Введи название проекта" />
    </div>
    <div class="work-form__field work-form__field--input">
      <BaseInput name="subtitle" v-model="work.subtitle" plcHolder="Введи название курса" />
    </div>
    <div class="work-form__field work-form__field--select">
      <select name="type" v-model="work.type" class="work-form__select">
        <option disabled value="">Выбери тип создаваемой работы</option>
        <option
          v-for="type in types"
          :value="type.title"
          :key="type.title"
        >{{ type.description }}</option>
      </select>
    </div>
    <div class="work-form__field work-form__field--input">
      <BaseInput name="link" v-model="work.link" plcHolder="Введи ссылку на готовый сайт" />
    </div>
    <div class="work-form__field work-form__field--file">
      <FileInput
        plcHolder="Перетащи сюда файл обложки или нажми, чтобы выбрать его"
        @onefileUpload="setMainImage"
        :editedImages="work.mainImage ? [work.mainImage] : []"
      />
    </div>
    <div class="work-form__field work-form__field--files">
      <FileInput
        multiple="true"
        plcHolder="Перетащи сюда файлы работы или нажми, чтобы выбрать их"
        @filesUpload="setWorkImages"
        :editedImages="work.images"
      />
    </div>
    <div class="work-form__field work-form__field--textarea">
      <textarea
        name="task"
        cols="30"
        rows="10"
        v-model="work.task"
        placeholder="Введи описание или цель проекта"
        class="work-form__textarea"
      ></textarea>
    </div>
    <div class="work-form__buttons">
      <Button text="Сохранить" modifier="invert" />
      <Button text="Отменить" modifier="cancel" type="reset" @click.prevent="goBack" />
    </div>
  </form>
</template>

<script>
import BaseInput from './BaseInput.vue';
import Button from './Button.vue';
import FileInput from './FileInput.vue';

export default {
  name: 'WorkForm',
  components: { BaseInput, Button, FileInput },
  props: {
    id: {
      required: false,
    },
  },
  data() {
    return {
      work: {
        type: '',
        title: '',
        subtitle: '',
        mainImage: null,
        task: '',
        link: '',
        images: [],
      },
      types: [],
      mainImageChanged: false,
      imagesChanged: false,
    };
  },
  methods: {
    goBack() {
      this.work = {
        type: '',
        title: '',
        subtitle: '',
        mainImage: null,
        task: '',
        link: '',
        images: [],
      };
      this.$router.go(-1);
    },
    setMainImage(file) {
      this.work.mainImage = file;
      this.mainImageChanged = true;
    },
    setWorkImages(files) {
      this.work.images = files;
      this.imagesChanged = true;
    },
    async saveWork() {
      const workData = new FormData();
      if (this.id) {
        workData.append('id', this.id);
      }
      workData.append('type', this.work.type);
      workData.append('title', this.work.title);
      workData.append('subtitle', this.work.subtitle);
      if (this.mainImageChanged) {
        workData.append('mainImage', this.work.mainImage);
      }
      workData.append('task', this.work.task);
      workData.append('link', this.work.link);
      workData.append('token', this.$store.state.userToken.token);
      if (this.imagesChanged) {
        this.work.images.forEach((img, i) => {
          workData.append(`images[${i}]`, img, img.name);
        });
      }
      try {
        let result = null;
        if (this.id) {
          result = await this.$store.dispatch('worksUpdate', workData);
        } else {
          result = await this.$store.dispatch('worksCreate', workData);
        }
        if (result.status === 'success') {
          this.$router.push('/admin');
        }
      } catch (error) {
        this.$store.dispatch('showError', error.message);
      }
    },
  },
  async mounted() {
    try {
      if (this.id) {
        this.work = await this.$store.dispatch('worksReadOneById', this.id);
      }
      this.types = await this.$store.dispatch('typesRead');
    } catch (error) {
      this.$store.dispatch('showError', error.message);
    }
  },
};
</script>
