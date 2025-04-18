import { User } from './user';

export interface Post {
    id: number;
    title: string;
    slug: string;
    content: string;
    collection_id: number;
    user_id: number;
    custom_fields: Record<string, any>;
    seo_meta: SeoMeta;
    published_at: string | null;
    status: PostStatus;
    created_at: string;
    updated_at: string;
    user?: User;
}

export enum PostStatus {
    DRAFT = 'draft',
    PUBLISHED = 'published',
    SCHEDULED = 'scheduled',
}

export interface SeoMeta {
    title: string;
    description: string;
    keywords: string[];
    og_image?: string;
    og_title?: string;
    og_description?: string;
} 