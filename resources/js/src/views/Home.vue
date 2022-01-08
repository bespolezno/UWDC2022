<template>
  <b-row class="">
    <b-col
      lg="3"
    >
      <b-card title="Logged working hours">
        <b-card-text></b-card-text>
      </b-card>

      <b-card title="12 months overview">
        <b-card-text>This is your second page.</b-card-text>
      </b-card>

      <b-card title="Categories">
        <b-card-text>This is your second page.</b-card-text>
      </b-card>

      <b-card title="Used technologies">
        <div class="badges">
          <b-badge
            v-for="tag in usedTags"
            :key="tag[0]"
          >
            {{ tag[0] }} {{ tag[1] }}
          </b-badge>
        </div>
      </b-card>

      <b-card title="Add new entry">
        <!-- form -->
        <validation-observer ref="entryValidation">
          <b-form
            class="auth-entry-form mt-2"
            @submit.prevent
          >
            <b-form-group
              label="Date *"
            >
              <validation-provider
                #default="{ errors }"
                name="Date *"
                rules="required"
              >
                <b-form-input
                  v-model="form.date"
                  :state="errors.length > 0 ? false:null"
                  name="entry-email"
                  placeholder="john@example.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <b-form-group
              label="Type *"
            >
              <validation-provider
                #default="{ errors }"
                name="Type *"
                rules="required"
              >
                <b-form-input
                  v-model="form.type"
                  :state="errors.length > 0 ? false:null"
                  name="entry-email"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <b-form-group
              label="Category *"
            >
              <validation-provider
                #default="{ errors }"
                name="Category *"
                rules="required"
              >
                <b-form-input
                  v-model="form.category"
                  :state="errors.length > 0 ? false:null"
                  name="entry-email"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <b-form-group
              label="Spent time *"
            >
              <validation-provider
                #default="{ errors }"
                name="Spent time *"
                rules="required"
              >
                <b-form-input
                  v-model.number="form.hours"
                  :state="errors.length > 0 ? false:null"
                  name="entry-email"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <b-form-group
              label="Notes"
            >
              <validation-provider
                #default="{ errors }"
                name="Notes"
              >
                <b-form-input
                  v-model="form.notes"
                  :state="errors.length > 0 ? false:null"
                  name="entry-email"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <b-form-group
              label="Tags *"
            >
              <validation-provider
                #default="{ errors }"
                name="Tags *"
                rules=""
              >
                <b-form-input
                  v-model="form.tagsList"
                  :state="errors.length > 0 ? false:null"
                  name="entry-email"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- submit buttons -->
            <b-button
              type="submit"
              variant="primary"
              @click="validationForm"
            >
              ADD ENTRY
            </b-button>
          </b-form>
        </validation-observer>
      </b-card>

    </b-col>

    <b-col
      lg="9"
    >
      <b-button
        type="submit"
        variant="primary"
        class="mb-2"
        @click="logout"
      >
        SIGN OUT
      </b-button>

      <vue-good-table
        :columns="columns"
        :rows="data"
      >
        <template
          slot="table-row"
          slot-scope="props"
        >

          <!-- Column: Tags -->
          <span
            v-if="props.column.field === 'tags'"
            class="badges"
          >
            <b-badge
              v-for="tag in props.row.tags"
              :key="tag"
            >
              {{ tag }}
            </b-badge>
          </span>

          <span v-else-if="props.column.field === 'hours'">
            {{ props.formattedRow[props.column.field] }}h
          </span>

          <!-- Column: Common -->
          <span v-else>
          {{ props.formattedRow[props.column.field] }}
        </span>
        </template>
      </vue-good-table>
    </b-col>
  </b-row>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BBadge,
  BButton,
  BCard,
  BCardText,
  BCol,
  BForm,
  BFormGroup,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
  BLink,
  BRow
} from 'bootstrap-vue';
import {VueGoodTable} from 'vue-good-table';
import '@core/scss/vue/libs/vue-good-table.scss';
import ToastificationContent from '@core/components/toastification/ToastificationContent';

export default {
  components: {
    BCard,
    BCardText,
    BLink,
    BRow,
    BCol,
    VueGoodTable,
    BBadge,
    BForm,
    BButton,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      form: {
        "date": "2022-01-01",
        "type": "New Entry",
        "category": "Backend",
        "hours": 1,
        "notes": "Sample text",
        "tags": [
          "tag1",
          "tag2"
        ]
      },
      columns: [
        {
          label: 'Date',
          field: 'date',
          type: 'date',
          dateInputFormat: 'yyyy-MM-dd',
          dateOutputFormat: 'dd.MM.Y',
        },
        {
          label: 'Type',
          field: 'type',
        },
        {
          label: 'Category',
          field: 'category',
        },
        {
          label: 'Time',
          field: 'hours',
          type: 'number',
        },
        {
          label: 'Notes',
          field: 'notes',
        },
        {
          label: 'Tags',
          field: 'tags',
        },
      ],
      data: [],
      types: [],
      categories: [],
      tags: [],
    };
  },
  computed: {
    usedTags () {
      const tags = this.data.map(el => el.tags).flat()
      const used = new Map()

      tags.forEach(tag => used.has(tag) ? used.set(tag, used.get(tag) + 1) : used.set(tag, 1))

      return [...used].sort((a, b) => b[1] - a[1])
    }
  },
  created() {
    this.loadAll()
  },
  methods: {
    logout () {
      localStorage.clear()
      this.$router.push({ name: 'login' })
    },
    /**
     * Loads all necessary data
     * @returns {Promise<void>}
     */
    async loadAll () {
      await Promise.all([
        this.loadTypes(),
        this.loadCategories(),
        this.loadTags(),
        this.loadSessions(),
      ])
    },
    async loadTypes () {
      const { data } = await this.$http.get('/types')

      this.data = data
    },
    async loadCategories () {
      const { data } = await this.$http.get('/categories')

      this.data = data
    },
    async loadTags () {
      const { data } = await this.$http.get('/tags')

      this.data = data
    },
    async loadSessions () {
      const { data } = await this.$http.get('/sessions')

      this.data = data
    },
    async validationForm() {
      try {
        await this.$http.post('/sessions', this.form)

        this.$toast({
          component: ToastificationContent,
          props: {
            title: 'Entry added successfully!',
            icon: 'CheckIcon',
            variant: 'success',
          },
        });

        await this.loadAll()
      } catch (error) {
        this.$toast({
          component: ToastificationContent,
          props: {
            title: 'Invalid data',
            icon: 'XIcon',
            variant: 'danger',
          },
        });
      }
    },
  },
};
</script>

<style lang="scss">
.badges {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}
</style>
