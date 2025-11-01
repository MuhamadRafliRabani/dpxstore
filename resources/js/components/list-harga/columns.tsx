'use client';

import { OrderType, ProductDtType } from '@/types';
import { ColumnDef } from '@tanstack/react-table';
import { Badge } from '../ui/badge';

// product_name;
// category;
// brand;
// type;
// seller_name;
// price;
export const columns: ColumnDef<ProductDtType>[] = [
    {
        accessorKey: 'buyer_sku_code',
        header: 'SKU Code',
        cell: ({ row }) => (
            <span className="block w-[120px] truncate text-xs font-medium sm:text-sm">{'#' + row.original.buyer_sku_code.toUpperCase() || '-'}</span>
        ),
    },
    {
        accessorKey: 'product_name',
        header: 'Produk Name',
        cell: ({ row }) => (
            <p className="block w-[200px] text-xs font-medium break-words whitespace-normal capitalize sm:text-sm">
                {row.original.product_name.toLowerCase()}
            </p>
        ),
    },
    {
        accessorKey: 'price',
        header: 'Harga',
        cell: ({ row }) => {
            const price: number = row.getValue('price');
            return (
                <span className="block w-[120px] text-xs font-medium sm:text-sm">
                    {new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                    }).format(price)}
                </span>
            );
        },
    },
    {
        accessorKey: 'category',
        header: 'Category',
        cell: ({ row }) => <span className="block w-[100px] text-xs font-medium sm:text-sm">{row.getValue('category')}</span>,
    },
    {
        accessorKey: 'maintenance',
        header: 'Maintenance Time',
        cell: ({ row }) => (
            <span className="block w-[160px] text-xs font-medium sm:text-sm">{row.original.start_cut_off + ' - ' + row.original.end_cut_off}</span>
        ),
    },
    {
        accessorKey: 'desc',
        header: 'Description',
        cell: ({ row }) => <p className="block w-[250px] text-xs font-medium break-words whitespace-normal sm:text-sm">{row.getValue('desc')}</p>,
    },
];

export const columnsOrder: ColumnDef<OrderType>[] = [
    {
        accessorKey: 'order_code',
        header: 'Order Code',
        cell: ({ row }) => row.getValue('order_code') || '-',
    },
    {
        accessorKey: 'data_user',
        header: 'Data User',
        cell: ({ row }) => {
            console.log(row.original.order_detail?.category_id);
            const category_id = row.original.order_detail?.category_id.toString() ?? '';

            switch (category_id) {
                case '1':
                    return <span className="text-xssm:text-sm font-medium">{row.original.order_detail?.user_id}</span>;
                case '2':
                    return <span className="text-xssm:text-sm font-medium">{row.original.order_detail?.no_handphone}</span>;
                case '3':
                    return null;
                case '4':
                    return <span className="text-xssm:text-sm font-medium">{row.original.order_detail?.no_akun}</span>;
                default:
                    return null;
            }
        },
    },
    {
        accessorKey: 'product_name',
        header: 'Product Name',
        cell: ({ row }) => (
            <p className="text-xssm:text-sm w-30 font-medium break-words whitespace-normal md:w-45">{row.original.order_detail?.product_name}</p>
        ),
    },
    {
        accessorKey: 'price',
        header: 'Price',
        cell: ({ row }) => {
            const price: number = row.getValue('price');
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(price);
        },
    },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            let background = '';
            const status = row.getValue('status') as string;

            switch (status.toLowerCase()) {
                case 'pending':
                    background = 'bg-embla-500';
                    break;
                case 'paid':
                    background = 'bg-blue-500';
                    break;
                case 'success':
                    background = 'bg-green-400';
                    break;
                case 'cancled':
                    background = 'bg-red-400';
                    break;
                case 'fail':
                    background = 'bg-red-500';
                    break;
                default:
                    background = '';
                    break;
            }
            return <Badge className={`font-medium ${background} text-accent-foreground`}>{row.getValue('status')}</Badge>;
        },
    },
    {
        accessorKey: 'start_process',
        header: 'Start Process',
        cell: ({ row }) => <span className="text-xssm:text-sm font-medium">{row.getValue('start_process')}</span>,
    },
    {
        accessorKey: 'end_process',
        header: 'End Process',
        cell: ({ row }) => <span className="text-center text-xs font-medium sm:text-sm">{row.getValue('end_process') || '-'}</span>,
    },
    {
        accessorKey: 'isvoucher',
        header: 'Voucher',
        cell: ({ row }) => <span className="text-xssm:text-sm font-medium">{row.getValue('isvoucher')}</span>,
    },
    {
        accessorKey: 'payment_type',
        header: 'Paid with',
        cell: ({ row }) => <span className="text-xssm:text-sm font-medium">{row.getValue('payment_type') || 'not paid yet'}</span>,
    },
];
