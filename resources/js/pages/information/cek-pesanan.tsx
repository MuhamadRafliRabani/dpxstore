import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { memo } from 'react';

const CekPesanan = memo(() => {
    return (
        <AppLayout>
            <section className="grid min-h-[55vh] place-content-center space-y-2">
                <h1 className="text-accent-foreground text-center text-sm font-semibold">Check Pesanan</h1>
                <Card className="m-auto w-full max-w-3xl min-w-[300px] sm:min-w-2xl lg:min-w-3xl">
                    <CardContent className="text-accent-foreground space-y-2">
                        <div className="text-xs font-medium">
                            <h2>Masukkan ID Pesanan</h2>
                        </div>
                        <Input
                            id="order-id"
                            placeholder="Masukan nomor Invoice Kamu (Contoh: 05xxxxxxxxxxxxx)"
                            className="placeholder:text-accent-foreground/80 text-accent-foreground/80 placeholder:text-xxs mt-4 text-sm sm:text-base"
                        />
                    </CardContent>
                    <CardFooter>
                        <Button className="ms-auto text-xs">Cari Invoice</Button>
                    </CardFooter>
                </Card>
            </section>
        </AppLayout>
    );
});

export default CekPesanan;
