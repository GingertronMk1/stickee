<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";

const props = defineProps<{
    widgets: integer | null,
    packs: array | null,
}>();

const form = useForm({widgets: props.widgets});
const submit = () => form.get('/');

</script>

<template>
    <input v-model="form.widgets" />
    <button @click="submit">Calculate</button>
    <table>
        <thead>
        <tr>
            <th>Pack Size</th>
            <th>Count</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(amount, packSize) in packs" :key="packSize">
            <td v-text="packSize" />
            <td v-text="amount" />
        </tr>
        </tbody>
    </table>
</template>
