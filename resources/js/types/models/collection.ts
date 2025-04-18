export interface Collection {
    id: number;
    name: string;
    slug: string;
    description: string | null;
    fields: CollectionField[];
    is_active: boolean;
    created_at: string;
    updated_at: string;
}

export interface CollectionField {
    name: string;
    type: FieldType;
    label: string;
    required: boolean;
    options?: string[];
    default?: any;
}

export enum FieldType {
    TEXT = 'text',
    TEXTAREA = 'textarea',
    NUMBER = 'number',
    DATE = 'date',
    DATETIME = 'datetime',
    SELECT = 'select',
    MULTISELECT = 'multiselect',
    FILE = 'file',
    IMAGE = 'image',
    BOOLEAN = 'boolean',
    JSON = 'json',
} 