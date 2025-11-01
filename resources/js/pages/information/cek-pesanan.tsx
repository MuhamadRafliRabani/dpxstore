import { columnsOrder } from '@/components/list-harga/columns';
import { DataTable } from '@/components/list-harga/data-table';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { OrderType } from '@/types';
import { useForm } from '@inertiajs/react';
import axios from 'axios';
import { LoaderCircle } from 'lucide-react';
import { memo, useState } from 'react';

const CekPesanan = memo(() => {
    const [orders, setOrders] = useState<OrderType[]>([]);
    const [isLoading, setIsLoading] = useState<boolean>(false);
    const { setData, data } = useForm({
        order_code: '',
    });
    // console.log('🚀 ~ orders:', errors.order_code);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setIsLoading(true);

        axios
            .post('/getOrder', data)
            .then(({ data }) => {
                setOrders(data);
            })
            .catch(({ response }) => {
                console.error(response.data);
            })
            .finally(() => {
                setIsLoading(false);
            });
    };

    console.error(orders);

    return (
        <AppLayout>
            <section className="grid min-h-[55vh] place-content-center space-y-2">
                <div className="">
                    <h1 className="text-accent-foreground text-center text-sm font-semibold">Check Pesanan</h1>
                    <Card className="m-auto w-full max-w-3xl min-w-[300px] sm:min-w-2xl lg:min-w-3xl">
                        <CardContent className="text-accent-foreground space-y-2">
                            <div className="mb-2 text-xs font-medium">
                                <h2>Masukkan ID Pesanan</h2>
                            </div>
                            <Input
                                id="order-id"
                                placeholder="Masukan nomor Invoice Kamu (Contoh: ORD3H2344)"
                                onChange={(e) => setData('order_code', e.target.value)}
                                className="placeholder:text-accent-foreground/80 text-accent-foreground/80 placeholder:text-xxs mt-4 text-sm sm:text-base"
                            />
                            {!orders && <span className="text-xxs ms-2 text-red-500/90 sm:text-xs">Order Code Yang Dimasukan Salah</span>}
                        </CardContent>
                        <CardFooter>
                            <Button className="ms-auto text-xs" onClick={handleSubmit} disabled={isLoading}>
                                {!isLoading ? <span>Cari Invoice</span> : <LoaderCircle className="size-4 animate-spin" />}
                            </Button>
                        </CardFooter>
                    </Card>
                </div>

                {orders.length != 0 && (
                    <div className="">
                        <DataTable columns={columnsOrder} data={orders} title={'Order'} />
                    </div>
                )}
            </section>
        </AppLayout>
    );
});

export default CekPesanan;
