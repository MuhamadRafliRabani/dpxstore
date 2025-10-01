'use client';

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { ColumnDef, flexRender, getCoreRowModel, getPaginationRowModel, useReactTable } from '@tanstack/react-table';
import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../ui/card';
import Image from '../ui/loading-image';
import { Pagination, PaginationContent, PaginationItem, PaginationLink, PaginationNext, PaginationPrevious } from '../ui/pagination';

export interface DataTableProps<TData, TValue> {
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    image: string;
    title: string;
    id: string;
}

export function DataTable<TData, TValue>({ columns, data, title, image, id }: DataTableProps<TData, TValue>) {
    const [pageIndex, setPageIndex] = useState(0);
    const pageSize = 10;

    const table = useReactTable({
        data,
        columns,
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        state: {
            pagination: {
                pageIndex,
                pageSize,
            },
        },
        onPaginationChange: (updater) => {
            const newState = typeof updater === 'function' ? updater({ pageIndex, pageSize }) : updater;
            setPageIndex(newState.pageIndex);
        },
        manualPagination: false,
    });

    return (
        <Card className="list translate-y-8 space-y-0 overflow-hidden opacity-0" id={id}>
            <CardHeader className="text-primary my-0 flex w-full flex-row justify-between">
                <div className="mt-2 w-fit">
                    <CardTitle className="text-lg font-semibold">
                        <h1>{title}</h1>
                    </CardTitle>
                    <CardDescription>
                        <h2 className="text-primary/80">Daftar harga untuk produk yang tersedia.</h2>
                    </CardDescription>
                </div>
                <Image src={image} className="my-auto size-20 rounded-md object-cover" />
            </CardHeader>
            <CardContent className="space-y-4">
                <Table>
                    <TableHeader>
                        {table.getHeaderGroups().map((headerGroup) => (
                            <TableRow key={headerGroup.id}>
                                {headerGroup.headers.map((header) => (
                                    <TableHead key={header.id} className="text-primary">
                                        {header.isPlaceholder ? null : flexRender(header.column.columnDef.header, header.getContext())}
                                    </TableHead>
                                ))}
                            </TableRow>
                        ))}
                    </TableHeader>
                    <TableBody>
                        {table.getRowModel().rows?.length ? (
                            table.getRowModel().rows.map((row) => (
                                <TableRow key={row.id} data-state={row.getIsSelected() && 'selected'}>
                                    {row.getVisibleCells().map((cell) => (
                                        <TableCell key={cell.id} className="text-primary/80">
                                            {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                        </TableCell>
                                    ))}
                                </TableRow>
                            ))
                        ) : (
                            <TableRow>
                                <TableCell colSpan={columns.length} className="h-24 text-center">
                                    Tidak ada data.
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>

                {/* Pagination */}
                <Pagination>
                    <PaginationContent className="text-primary hover:text-primary">
                        {table.getCanPreviousPage() && (
                            <PaginationItem>
                                <button
                                    onClick={() => {
                                        table.previousPage();
                                        document.getElementById(id)?.scrollIntoView();
                                    }}
                                >
                                    <PaginationPrevious />
                                </button>
                            </PaginationItem>
                        )}

                        {Array.from({ length: table.getPageCount() }, (_, i) => (
                            <PaginationItem key={i}>
                                <button
                                    onClick={() => {
                                        table.setPageIndex(i);
                                        document.getElementById(id)?.scrollIntoView();
                                    }}
                                >
                                    <PaginationLink isActive={table.getState().pagination.pageIndex === i}>{i + 1}</PaginationLink>
                                </button>
                            </PaginationItem>
                        ))}

                        {table.getCanNextPage() && (
                            <PaginationItem>
                                <button
                                    onClick={() => {
                                        table.nextPage();
                                        document.getElementById(id)?.scrollIntoView();
                                    }}
                                >
                                    <PaginationNext />
                                </button>
                            </PaginationItem>
                        )}
                    </PaginationContent>
                </Pagination>
            </CardContent>
        </Card>
    );
}
