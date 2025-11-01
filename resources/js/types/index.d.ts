import { LucideIcon } from 'lucide-react';
import { Dispatch, SetStateAction } from 'react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface PageProps {
    title: string;
    description: string;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface CategoryState {
    category: number;
    setCategory: (state: number) => void;
}

export interface CardProductProps {
    id?: number;
    title: string;
    publisher?: string;
    image: string;
    category?: string;
    games?: string;
    key?: number;
    url: string;
}

type ProductData = {
    code: string;
    name: string;
    price: number;
    status: 'On' | 'Off';
};

type BannerType = 'small' | 'medium' | 'large';

interface Banner {
    id: number;
    configuration_id: number;
    title: string;
    image: string;
    url: string | null;
    type: BannerType;
    sort_order: number;
    created_at: string;
    updated_at: string;
}

export interface GameType {
    id: number;
    name: string;
    category_id: number;
    category?: categoriesType;
    image: string;
    slug: string;
    target: string;
    sort: number;
    content: string;
    status: 'On' | 'Off';
    check_status: 'Y' | 'N';
    check_code: string;
    code: string;
    provider: string;
    full_input: boolean;
    publisher?: string;
    created_at: string;
    updated_at: string;
}

export interface ProductPopulerType {
    id: number;
    image: string;
    game_id: number;
    provider: string;
    created_at: string;
    category_id: number;
    updated_at: string;
    product: GameType; // ini relasi-nya
}

export interface categoriesType {
    id: number;
    name: string;
    title: string;
    description: string;
    creby: string;
    cretime: string;
    modby: string;
    modtime: string;
}

export interface PaginatedResponse<T> {
    data: T[];
    current_page: number;
    last_page: number;
    total: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}

export interface ProductType {
    id: number;
    name: string;
    category_id: string;
    image: string;
    slug: string;
    code: string;
    publisher: string;
    status: boolean;
    full_input: boolean;
    creby: string;
    cretime: string;
    modby: string;
    modtime: string;
    product_item?: ProductDtType[];
}

export interface ProductDtType {
    id: number;
    product_name: string;
    category: string;
    brand: string;
    type: string;
    seller_name: string;
    price: number;
    buyer_sku_code: string;
    buyer_product_status: boolean;
    seller_product_status: boolean;
    unlimited_stock: boolean;
    stock: number | string;
    multi: boolean;
    start_cut_off: string;
    end_cut_off: string;
    desc: string;
    creby: string;
    cretime: string;
    modby: string;
    modtime: string;
}

export interface configuration {
    id: number;
    description: string;
    keywords: string;
    logo: string;
    logo_header: string;
    website: string;
    created_at: string;
    updated_at: string;
}

export interface DataOrder {
    user_id: string;
    zone_id: string;
    no_handphone: string;
    no_akun: string;
    voucher_code: string;
    whatsapp: string;
    product_id: number | null;
}

export interface inputOrder {
    data: DataOrder;
    username?: string | null;
    loading?: boolean;
    setData: (key: string, value: string) => void;
    errors: Partial<Record<'user_id' | 'zone_id' | 'no_handphone' | 'no_akun' | 'voucher_code' | 'whatsapp' | 'product_id', string>>;
    full_input?: boolean;
}

export interface productContentType {
    data: DataOrder;
    username?: string | null;
    loading?: boolean;
    category_name: string | unknown;
    products: ProductDtType[];
    setData: (key: string, value: string | number) => void;
    errors: Partial<Record<'user_id' | 'zone_id' | 'no_handphone' | 'no_akun' | 'voucher_code' | 'whatsapp' | 'product_id', string>>;
}

export interface InputDataUser {
    key: string;
    setData: (key: string, value: string) => void;
    e: ChangeEvent<HTMLInputElement>;
}

export interface SearchType {
    search: Ref<HTMLDivElement> | undefined;
    showSearch: boolean;
    cardSearch: Ref<HTMLDivElement> | undefined;
    setShowSearch: Dispatch<SetStateAction<boolean>>;
}

export interface OrderType {
    id: string;
    order_code: string;
    price: number;
    start_process: string;
    end_process: string;
    isvoucher: boolean;
    payment_type: string;
    creby: string;
    cretime: string;
    modby: string;
    modtime: string;
    order_detail?: OrderDetailType;
}

export interface OrderDetailType {
    id: string;
    order_id: string;
    category_id: string;
    product_id: string;
    voucher_id: string;
    user_id: string;
    username: string;
    no_handphone: string;
    no_akun: string;
    whatsapp: string;
    category_name?: string;
    voucher?: string;
    product_name?: string;
    creby: string;
    cretime: string;
    modby: string;
    modtime: string;
}
