<template>
    <div class="shadow-md rounded sm:my-2">
        <div class="bg-gray-300 px-4 py-6">
            <div>
                <span class="text-xl px-1 leading-6 font-medium text-gray-900">Order Summary</span>
                <div class="flex justify-between bg-white px-4 py-2 mt-4">
                    <span>Item(s) subtotal({{ $page.props.cartCount }})</span>
                    <span>{{ $filters.formatCurrency(newSubtotal) }}</span>
                </div>
                <div class="flex justify-between px-1 mt-4">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="flex justify-between px-4 mt-4" v-if="code">
                    <span>Discount Code ({{ code }})</span>
                    <form @submit.prevent="deleteCoupon">
                        <span>-{{ $filters.formatCurrency(discount) }}</span>
                        <button type="submit" class="text-red-600 ml-2">X</button>
                    </form>
                </div>
                <div class="flex justify-between px-1 mt-4">
                    <span>Estimated Tax</span>
                    <span>{{ $filters.formatCurrency(tax) }}</span>
                </div>
                <div class="bg-white px-4 py-2 mt-4">
                    <div class="flex justify-between">
                        <span>Order Total</span>
                        <span>{{ $filters.formatCurrency(total) }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span>({{ taxRate }}% tax rate)</span>
                        <span>Lorem ipsum elit.</span>
                    </div>
                </div>
                <div class="flex flex-col items-left  mt-4 py-6" v-if="!code">
                    <span class="text-xl px-1 leading-6 font-medium text-gray-900">Promo</span>
                    <form @submit.prevent="addCoupon" class="w-full">
                        <div class="bg-gray-300">
                            <div>
                                <div class="flex items-center px-1 py-4 mt-2">
                                    <input type="text" class="w-full bg-white" placeholder="Enter Promo Code Here" v-model="form.coupon_code">
                                    <div class="text-center ml-4">
                                        <MainButton like="button" class="text-sm">
                                            Apply
                                        </MainButton>
                                    </div>
                                    <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.message">
                                        {{ $page.props.errors.message }}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <!-- Create two radio boxes to choose between the two payment methods  between cash on delivery and credit card -->
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-1 py-5 sm:px-1">
                        <h3 class="text-xl leading-6 font-medium text-gray-900">
                            Payment method
                        </h3>
                        <p class="mt-1 max-w 2xl text-sm text-gray-500">
                            Please choose your preferred payment method.
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Cash on delivery
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="relative flex items-start">
                                        <div class="flex items center h-5">
                                            <input id="cash" name="payment_method" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" checked>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="cash" class="font-medium text-gray-700">Cash on delivery</label>
                                            <p class="text-gray-500">Pay with cash when your order is delivered.</p>
                                        </div>
                                    </div>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Credit card
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="relative flex items-start">
                                        <div class="flex items center h-5">
                                            <input id="credit" name="payment_method" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="credit" class="font-medium text-gray-700">Credit card</label>
                                            <p class="text-gray-500">Pay with your credit card.</p>
                                        </div>
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <YellowButton :href="route('checkout.index')" like="href" class="text-sm">Secure Checkout</YellowButton>
                </div>
            </div>
            <div class="text-center mt-4">
                <Link :href="route('shop.index')" class="underline hover:text-red-700 transition">Continue Shopping</Link>
            </div>
        </div>
    </div>

</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import MainButton from '@/Components/Buttons/MainButton.vue';
    import YellowButton from '@/Components/Buttons/YellowButton.vue';
    export default defineComponent({
        props: ['taxRate', 'subtotal', 'tax', 'total', 'newSubtotal', 'code', 'discount'],
        components: {
            Link,
            MainButton,
            YellowButton,
        },
        data() {
            return {
                form: this.$inertia.form({
                    coupon_code: '',
                })
            }
        },
        methods: {
            addCoupon() {
                this.form.post(this.route('coupon.apply'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.reset()
                        Toast.fire({
                            icon: 'success',
                            title: 'Coupon has been added!'
                        })
                    }
                })
            },
            deleteCoupon() {
                this.form.delete(this.route('coupon.remove'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Coupon has been removed!'
                        })
                    }
                })
            }
        }
    })
</script>
