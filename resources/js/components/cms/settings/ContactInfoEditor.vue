<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Plus, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

interface Phone {
    href: string;
    text: string;
    showOnFooter: boolean;
}

interface Email {
    href: string;
    icon: string;
    text: string;
    showOnFooter: boolean;
}

interface WhatsApp {
    href: string;
    text: string;
    showOnFooter: boolean;
}

interface ContactInfo {
    email?: Email;
    phone?: Phone[];
    whatsapp?: WhatsApp;
    phoneIcon?: string;
}

interface Props {
    modelValue?: ContactInfo | null;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: () => ({ phone: [], phoneIcon: 'icon-phone-call' }),
});

const emit = defineEmits<{
    'update:modelValue': [value: ContactInfo];
}>();

const contactInfo = computed({
    get: () => {
        const defaultVal = { phone: [], phoneIcon: 'icon-phone-call' };
        return props.modelValue || defaultVal;
    },
    set: (value) => {
        // Asegurar que nunca se emita null
        emit('update:modelValue', value || { phone: [], phoneIcon: 'icon-phone-call' });
    },
});

const updateField = (field: keyof ContactInfo, value: any) => {
    contactInfo.value = { ...contactInfo.value, [field]: value };
};

const updateEmail = (field: keyof Email, value: string | boolean) => {
    const email = contactInfo.value.email || { href: '', icon: 'icon-envelope', text: '', showOnFooter: true };
    updateField('email', { ...email, [field]: value });
};

const updateWhatsApp = (field: keyof WhatsApp, value: string | boolean) => {
    const whatsapp = contactInfo.value.whatsapp || { href: '', text: '', showOnFooter: true };
    updateField('whatsapp', { ...whatsapp, [field]: value });
};

const addPhone = () => {
    const phones = contactInfo.value.phone || [];
    updateField('phone', [
        ...phones,
        { href: '', text: '', showOnFooter: true },
    ]);
};

const removePhone = (index: number) => {
    const phones = contactInfo.value.phone || [];
    updateField('phone', phones.filter((_, i) => i !== index));
};

const updatePhone = (index: number, field: keyof Phone, value: string | boolean) => {
    const phones = [...(contactInfo.value.phone || [])];
    phones[index] = { ...phones[index], [field]: value };
    updateField('phone', phones);
};
</script>

<template>
    <div class="space-y-6">
        <!-- Email -->
        <div class="rounded-lg border p-4 space-y-4">
            <Label class="text-base">Correo electrónico</Label>
            
            <div class="space-y-2">
                <Label for="email-text">Texto del correo *</Label>
                <Input
                    id="email-text"
                    :model-value="contactInfo.email?.text || ''"
                    placeholder="contacto@fecmemx.com"
                    @update:model-value="updateEmail('text', $event as string)"
                />
            </div>

            <div class="space-y-2">
                <Label for="email-href">Enlace (mailto:) *</Label>
                <Input
                    id="email-href"
                    :model-value="contactInfo.email?.href || ''"
                    placeholder="mailto:contacto@fecmemx.com"
                    @update:model-value="updateEmail('href', $event as string)"
                />
            </div>

            <div class="space-y-2">
                <Label for="email-icon">Icono</Label>
                <Input
                    id="email-icon"
                    :model-value="contactInfo.email?.icon || 'icon-envelope'"
                    placeholder="icon-envelope"
                    @update:model-value="updateEmail('icon', $event as string)"
                />
            </div>

            <div class="flex items-center gap-2">
                <Checkbox
                    :checked="contactInfo.email?.showOnFooter ?? true"
                    @update:checked="updateEmail('showOnFooter', $event)"
                />
                <Label class="cursor-pointer">Mostrar en footer</Label>
            </div>
        </div>

        <!-- Teléfonos -->
        <div class="rounded-lg border p-4 space-y-4">
            <div class="flex items-center justify-between">
                <Label class="text-base">Teléfonos</Label>
                <Button type="button" variant="outline" size="sm" @click="addPhone">
                    <Plus class="mr-2 h-4 w-4" />
                    Agregar teléfono
                </Button>
            </div>

            <div class="space-y-2">
                <Label for="phone-icon">Icono de teléfono</Label>
                <Input
                    id="phone-icon"
                    :model-value="contactInfo.phoneIcon || 'icon-phone-call'"
                    placeholder="icon-phone-call"
                    @update:model-value="updateField('phoneIcon', $event as string)"
                />
            </div>

            <div v-if="!contactInfo.phone || contactInfo.phone.length === 0" class="text-sm text-muted-foreground py-2 text-center">
                No hay teléfonos configurados.
            </div>

            <div v-else class="space-y-4">
                <div
                    v-for="(phone, index) in contactInfo.phone"
                    :key="index"
                    class="rounded border p-4 space-y-3"
                >
                    <div class="flex items-center justify-between">
                        <Label>Teléfono {{ index + 1 }}</Label>
                        <Button
                            type="button"
                            variant="ghost"
                            size="icon"
                            @click="removePhone(index)"
                        >
                            <Trash2 class="h-4 w-4 text-destructive" />
                        </Button>
                    </div>

                    <div class="space-y-2">
                        <Label>Número (texto) *</Label>
                        <Input
                            :model-value="phone.text"
                            placeholder="33-2267-2400"
                            @update:model-value="updatePhone(index, 'text', $event as string)"
                        />
                    </div>

                    <div class="space-y-2">
                        <Label>Enlace (tel:) *</Label>
                        <Input
                            :model-value="phone.href"
                            placeholder="tel:3322672400"
                            @update:model-value="updatePhone(index, 'href', $event as string)"
                        />
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox
                            :checked="phone.showOnFooter"
                            @update:checked="updatePhone(index, 'showOnFooter', $event)"
                        />
                        <Label class="cursor-pointer">Mostrar en footer</Label>
                    </div>
                </div>
            </div>
        </div>

        <!-- WhatsApp -->
        <div class="rounded-lg border p-4 space-y-4">
            <Label class="text-base">WhatsApp</Label>
            
            <div class="space-y-2">
                <Label for="whatsapp-text">Número (texto) *</Label>
                <Input
                    id="whatsapp-text"
                    :model-value="contactInfo.whatsapp?.text || ''"
                    placeholder="33-4320-0618"
                    @update:model-value="updateWhatsApp('text', $event as string)"
                />
            </div>

            <div class="space-y-2">
                <Label for="whatsapp-href">Enlace (WhatsApp API) *</Label>
                <Input
                    id="whatsapp-href"
                    :model-value="contactInfo.whatsapp?.href || ''"
                    placeholder="https://api.whatsapp.com/send?phone=5213343200618&text=Hola"
                    @update:model-value="updateWhatsApp('href', $event as string)"
                />
            </div>

            <div class="flex items-center gap-2">
                <Checkbox
                    :checked="contactInfo.whatsapp?.showOnFooter ?? true"
                    @update:checked="updateWhatsApp('showOnFooter', $event)"
                />
                <Label class="cursor-pointer">Mostrar en footer</Label>
            </div>
        </div>
    </div>
</template>
