<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';

interface Props {
    open: boolean;
    userId: number | null;
    userName?: string;
}

const props = defineProps<Props>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const form = useForm({
    password: '',
    password_confirmation: '',
});

const handleOpenChange = (value: boolean) => {
    emit('update:open', value);
    if (!value) {
        form.reset();
        form.clearErrors();
    }
};

const submit = () => {
    if (props.userId) {
        form.post(`/cms/users/${props.userId}/change-password`, {
            onSuccess: () => {
                handleOpenChange(false);
            },
        });
    }
};

watch(() => props.open, (newValue) => {
    if (!newValue) {
        form.reset();
        form.clearErrors();
    }
});
</script>

<template>
    <Dialog :open="open" @update:open="handleOpenChange">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Cambiar contraseña</DialogTitle>
                <DialogDescription>
                    {{ userName ? `Cambiar la contraseña de ${userName}` : 'Ingresa la nueva contraseña' }}
                </DialogDescription>
            </DialogHeader>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-2">
                    <Label for="password">Nueva contraseña *</Label>
                    <Input
                        id="password"
                        v-model="form.password"
                        type="password"
                        placeholder="Mínimo 8 caracteres"
                        required
                    />
                    <p v-if="form.errors.password" class="text-sm text-destructive">
                        {{ form.errors.password }}
                    </p>
                </div>
                <div class="space-y-2">
                    <Label for="password_confirmation">Confirmar contraseña *</Label>
                    <Input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        placeholder="Confirma la nueva contraseña"
                        required
                    />
                    <p v-if="form.errors.password_confirmation" class="text-sm text-destructive">
                        {{ form.errors.password_confirmation }}
                    </p>
                </div>
                <DialogFooter>
                    <Button
                        type="button"
                        variant="outline"
                        @click="handleOpenChange(false)"
                        :disabled="form.processing"
                    >
                        Cancelar
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Cambiar contraseña' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
