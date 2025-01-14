<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";

interface PackCalculation {
    pack_sizes: number[];
    widget_count: number;
    packs: Record<number, number>;
    created_at?: Date;
}

const props = defineProps<{
    widgets?: number,
    packs: PackCalculation,
    lookedUp: boolean,
    errors: {
        widgets: string
    },
}>();

const form = useForm<{ widgets?: number }>({widgets: props.widgets});
const submit = () => form.get('/');

</script>

<template>
    <header class="p-6 bg-blue-700 text-white">
        <h1 class="text-3xl">Welcome to Wally's Widgets!</h1>
    </header>
    <main class="py-3">
        <div class="w-11/12 max-w-screen-xl mx-auto">
            <div class="border-2 border-gray-500 rounded-lg p-4 mb-3">
                <label for="widget_count" class="flex flex-col mb-3">
                    <span>Please enter the desired number of Widgets</span>
                    <span v-if="errors.widgets" v-text="errors.widgets" class="text-red-600" />
                    <input name="widget_count" v-model="form.widgets" type="number" min="0" class="rounded-md"/>
                </label>
                <button @click="submit" class="bg-blue-700 rounded-md text-white p-2">Calculate</button>
            </div>

           <template v-if="packs.widget_count > 0" >
            <table class="border-collapse border border-slate-500 w-full">
                <thead>
                <tr>
                    <th class="border border-slate-600 p-3">Pack Size</th>
                    <th class="border border-slate-600 p-3">Count</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(amount, packSize) in packs.packs" :key="packSize">
                    <td class="border border-slate-700 p-3" v-text="packSize"/>
                    <td class="border border-slate-700 p-3" v-text="amount"/>
                </tr>
                </tbody>
            </table>

            <span >This value {{ lookedUp ? 'was' : 'was not' }} retrieved from the database</span>
           </template>
        </div>
    </main>
</template>
