'use client';

import { ProductType } from '@/types';
import { ColumnDef } from '@tanstack/react-table';

// product_name;
// category;
// brand;
// type;
// seller_name;
// price;
export const columns: ColumnDef<ProductType>[] = [
    {
        accessorKey: 'buyer_sku_code',
        header: 'Kode',
        cell: ({ row }) => row.getValue('buyer_sku_code') || '-',
    },
    {
        accessorKey: 'product_name',
        header: 'Produk',
        cell: ({ row }) => <span className="font-medium">{row.getValue('product_name')}</span>,
    },
    {
        accessorKey: 'category',
        header: 'Category',
        cell: ({ row }) => <span className="font-medium">{row.getValue('category')}</span>,
    },
    {
        accessorKey: 'price',
        header: 'Harga',
        cell: ({ row }) => {
            const price: number = row.getValue('price');
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(price);
        },
    },
];
