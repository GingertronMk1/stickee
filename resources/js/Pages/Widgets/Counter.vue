<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";

interface PackCalculation {
    pack_sizes: Array<number>;
    widget_count: number;
    packs: Record<number, number>;
    created_at?: Date;
}

const props = defineProps<{
    widgets: integer | null,
    packs: PackCalculation,
    lookedUp: boolean,
}>();

const form = useForm<{widgets: integer|null}>({widgets: props.widgets});
const submit = () => form.get('/');

</script>

<template>
    <span>This value {{ lookedUp ? 'was' : 'was not' }} retrieved from the database</span>
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
        <tr v-for="(amount, packSize) in packs.packs" :key="packSize">
            <td v-text="packSize" />
            <td v-text="amount" />
        </tr>
        </tbody>
    </table>
</template>
