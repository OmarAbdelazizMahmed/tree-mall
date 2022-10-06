<template>
    <JetFormSection @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <JetLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          :style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <JetSecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </JetSecondaryButton>

                <JetSecondaryButton type="button" class="mt-2" @click.prevent="deletePhoto" v-if="user.profile_photo_path">
                    Remove Photo
                </JetSecondaryButton>

                <JetInputError :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Name" />
                <JetInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="email" value="Email" />
                <JetInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <JetInputError :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="address" value="Address" />
                <JetInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
                <JetInputError :message="form.errors.address" class="mt-2" />
            </div>

            <!-- City -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="city" value="City" />
                <JetInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
                <JetInputError :message="form.errors.city" class="mt-2" />
            </div>

            <!-- State  -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="state" value="State" />
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 w-full" :value="form.state" id="state" required v-model="form.state">
                        <option disabled value="">Please select one</option>
                        <option v-for="(state, index) in states" :key="index" :selected="state === form.state">{{ state }}</option>
                    </select>
                <JetInputError :message="form.errors.state" class="mt-2" />
            </div>

            <!-- Zip Code -->
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="zip_code" value="Zip Code" />
                <JetInput id="zip_code" type="text" class="mt-1 block w-full" v-model="form.zip_code" />
                <JetInputError :message="form.errors.zip_code" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </JetActionMessage>

            <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </JetButton>
        </template>
    </JetFormSection>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetButton from '@/Components/Button.vue'
    import JetFormSection from '@/Components/FormSection.vue'
    import JetInput from '@/Components/Input.vue'
    import JetInputError from '@/Components/InputError.vue'
    import JetLabel from '@/Components/Label.vue'
    import JetActionMessage from '@/Components/ActionMessage.vue'
    import JetSecondaryButton from '@/Components/SecondaryButton.vue'
    import states from '@/states'
    export default defineComponent({
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },
        props: ['user'],
        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    address: this.user.billing_details.address,
                    city: this.user.billing_details.city,
                    state: this.user.billing_details.state,
                    zip_code: this.user.billing_details.zip_code,
                    photo: null,
                }),
                states: states,
                photoPreview: null,
            }
        },
        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }
                this.form.post(route('user-profile-information.update'), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true,
                    onSuccess: () => (this.clearPhotoFileInput()),
                });
            },
            selectNewPhoto() {
                this.$refs.photo.click();
            },
            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];
                if (! photo) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(photo);
            },
            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.photoPreview = null;
                        this.clearPhotoFileInput();
                    },
                });
            },
            clearPhotoFileInput() {
                if (this.$refs.photo?.value) {
                    this.$refs.photo.value = null;
                }
            },
        },
    })
</script>
