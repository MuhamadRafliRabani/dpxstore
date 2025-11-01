/* eslint-disable @typescript-eslint/no-explicit-any */
import InputWraper from '@/components/input-wraper';
import ProductContent from '@/components/product-section-content';
import InputDatapulsa from '@/components/show/data&pulsa';
import InputGame from '@/components/show/game-input';
import InputTagihan from '@/components/show/tagihan-input';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { GameType, ProductDtType } from '@/types';
import { useForm, usePage } from '@inertiajs/react';
import axios from 'axios';
// eslint-disable-next-line @typescript-eslint/ban-ts-comment
import { Info } from 'lucide-react';
import { JSX, useState } from 'react';

const ShowProduct = () => {
    const { product_dt, product, category } = usePage<{ product_dt: ProductDtType[]; product: GameType; category: string }>().props;
    const [loadingToken, setLoadingToken] = useState<boolean>(false);
    // const [voucherResult, setVoucherResult] = useState<any>(null);

    const [loading, setLoading] = useState(false);
    console.log(setLoading);
    // store data form
    const { data, setData, errors } = useForm({
        user_id: '',
        zone_id: '',
        no_handphone: '',
        no_akun: '',
        username: null,
        voucher_code: '',
        whatsapp: '',
        product_id: null as number | null,
    });

    // useEffect(() => {
    //     if (product.full_input ? data.user_id && data.zone_id : data.user_id) {
    //         const debouncedCheck = useDebounce(() => {
    //             setLoading(true);

    //             axios
    //                 .post(route('check.user'), {
    //                     user_id: data.user_id,
    //                     zone_id: data.zone_id,
    //                     game_code: product.code,
    //                 })
    //                 .then(({ data }) => {
    //                     setData('username', data.response?.data.username ?? null);
    //                 })
    //                 .catch((err) => {
    //                     console.log('🚀 ~ debouncedCheck ~ err:', err);
    //                 })
    //                 .finally(() => {
    //                     setLoading(false);
    //                 });
    //         }, 500);

    //         debouncedCheck();

    //         return () => debouncedCheck.cancel();
    //     }
    //     console.log({ user: data.user_id, zone: data.zone_id, game: product.code });
    // }, [data.user_id, data.zone_id, product.code, setData]);

    // const handleCheckVoucher = () => {
    //     router.post(
    //         route('voucher.check'),
    //         {
    //             code: data.voucher_code,
    //         },
    //         {
    //             onSuccess: ({ props }) => setVoucherResult(props.voucherData),
    //             onError: () => setVoucherResult(null),
    //         },
    //     );
    // };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setLoadingToken(true);

        axios
            .post('/checkout', data)
            .then(({ data }) => {
                // eslint-disable-next-line @typescript-eslint/ban-ts-comment
                // @ts-ignore
                window.snap.pay(data.snapToken, {
                    onSuccess: (result: string) => {
                        console.log('Pembayaran sukses:', result);
                    },
                    onPending: (result: any) => {
                        console.log('Menunggu pembayaran:', result);
                    },
                    onError: (result: any) => {
                        console.error('Pembayaran gagal:', result);
                    },
                });
            })
            .catch((err) => {
                console.error({ ini_callback: err });
            })
            .finally(() => {
                setLoadingToken(false);
            });
    };

    const isFormValid = () => {
        if (category === 'pulsa & data') {
            return !data.no_handphone.trim() || !data.product_id || !data.whatsapp;
        }

        if (category === 'games') {
            if (product.full_input == true) {
                return !data.user_id.trim() || !data.zone_id.trim() || !data.product_id || !data.whatsapp;
            }
            return !data.user_id.trim() || !data.product_id || !data.whatsapp;
        }

        if (category === 'voucher') {
            return !data.product_id || !data.whatsapp;
        }

        if (category === 'tagihan') {
            return !data.no_akun.trim() || !data.product_id || !data.whatsapp;
        }

        // fallback: kategori lain belum didukung
        return false;
    };

    const inputComponents: Record<string, JSX.Element | null> = {
        'pulsa & data': <InputDatapulsa data={data} setData={setData} errors={errors} />,
        games: (
            <InputGame username={data?.username} loading={loading} data={data} setData={setData} errors={errors} full_input={product.full_input} />
        ),
        tagihan: <InputTagihan data={data} setData={setData} errors={errors} />,
        voucher: null,
    };

    return (
        <AppLayout>
            <section className="relative space-y-6 p-2 sm:p-3.5">
                {/* banner image */}
                <div className="max-h-70 w-full overflow-hidden">
                    <img src={`/storage/banners/dummy-banner.jpg`} alt={product.name} className="h-full w-full object-cover" />
                </div>

                {/* Header */}
                <div className="bg-order-header-background bg-card bg-order-header-background text-order-header-foreground flex h-26 w-full flex-col justify-center gap-4 px-4 sm:h-31">
                    <div className="flex items-center gap-4">
                        <div className="size-12 object-cover sm:size-16">
                            <img src={`/storage/${product.image}`} alt={product.name} className="h-full w-full rounded-md object-cover" />
                        </div>
                        <div className="text-accent-foreground space-y-2 text-xs font-medium sm:text-sm">
                            <h1>{product.name}</h1>
                            <p>{product.publisher || ''}</p>
                        </div>
                    </div>
                    <div className="text-primary/80 -ms-2 space-x-2 text-xs whitespace-nowrap sm:ms-0 sm:flex sm:gap-4 sm:space-x-0 sm:text-sm">
                        <span>⚡ Proses Cepat</span>
                        <span>
                            💬 Layanan <span className="hidden sm:inline-block">Chat</span> 24/7
                        </span>
                        <span className="">🔒 Pembayaran Aman!</span>
                    </div>
                </div>

                <form action="" method="post" onSubmit={handleSubmit} className="">
                    <div className="justify-center gap-4 lg:flex">
                        {/* Right: Form Input */}
                        <div className="space-y-4 lg:flex-[60%]">
                            {category != 'voucher' && (
                                <div className="lg:hidden">
                                    <InputWraper title="Lengkapi Data Diri" number={1}>
                                        <div className="space-y-2 p-4 pt-2">{inputComponents[category]}</div>
                                    </InputWraper>
                                </div>
                            )}

                            {/* Left: Product List */}

                            <InputWraper title="Pilih Product" number={category === 'voucher' ? 1 : 2}>
                                {errors.product_id && !data.product_id && (
                                    <div className="error-style">
                                        <p className="">Pilih salah satu produt</p>
                                    </div>
                                )}
                                <ProductContent category_name={category} data={data} setData={setData} products={product_dt} errors={errors} />
                            </InputWraper>

                            <InputWraper title="Kode Voucher" number={category === 'voucher' ? 2 : 3}>
                                <div className="flex items-center gap-2 p-4">
                                    <Input
                                        placeholder="Ketik kode promo kamu"
                                        value={data.voucher_code}
                                        onChange={(e) => setData('voucher_code', e.target.value)}
                                        className="placeholder:text-accent-foreground/40 bg-accent-foreground/10 text-xxs text-accent flex-1 md:text-xs md:placeholder:text-xs dark:text-white"
                                    />
                                    <Button
                                        variant="secondary"
                                        className="bg-accent-foreground text-accent text-xxs hover:bg-accent-foreground font-medium"
                                    >
                                        CEK
                                    </Button>
                                </div>
                            </InputWraper>

                            <InputWraper title="Kontak" number={category === 'voucher' ? 3 : 4}>
                                <div className="space-y-3 p-4">
                                    <Label className="text-accent-foreground text-xs font-medium">No. WhatsApp</Label>
                                    <div className="mt-2 flex gap-2">
                                        <Input
                                            readOnly={true}
                                            placeholder="+62"
                                            className="bg-accent-foreground/10 text-xxs placeholder:text-accent-foreground/40 text-accent w-[50px] text-center opacity-60 md:text-xs md:placeholder:text-xs dark:text-white"
                                        />
                                        <Input
                                            id="whatsapp"
                                            placeholder="0812 3456 7890"
                                            value={data.whatsapp}
                                            type="number"
                                            onChange={(e) => setData('whatsapp', e.target.value)}
                                            className="placeholder:text-accent-foreground/40 bg-accent-foreground/10 text-xxs text-accent flex-1 md:text-xs md:placeholder:text-xs dark:text-white"
                                        />
                                    </div>

                                    <p className="text-accent-foreground/70 text-xxs">**Nomor ini akan dihubungi jika terjadi masalah</p>
                                    <div className="text-accent-foreground bg-accent-foreground/10 text-xxs flex items-start gap-2 rounded-lg p-2">
                                        <Info className="text-accent-foreground size-3.5" />
                                        <span>Jika ada kendala, kami akan menghubungi nomor diatas</span>
                                    </div>
                                </div>
                            </InputWraper>

                            <Button
                                className={`text-accent-foreground w-full bg-yellow-400 hover:scale-99 hover:brightness-105 md:sticky md:top-94 ${isFormValid() || loading ? 'cursor-not-allowed opacity-50' : ''}`}
                                type="submit"
                                disabled={isFormValid() || loading || loadingToken}
                            >
                                {loadingToken ? 'Memproses...' : 'Pesan Sekarang'}
                            </Button>
                        </div>

                        <div className="sticky top-0 hidden space-y-4 lg:inline-flex lg:flex-auto">
                            {category != 'voucher' && (
                                <div className="">
                                    <InputWraper title="Lengkapi Data Diri" number={1}>
                                        <div className="space-y-2 p-4 pt-2">{inputComponents[category]}</div>
                                    </InputWraper>
                                </div>
                            )}
                        </div>
                    </div>
                </form>
            </section>
        </AppLayout>
    );
};

export default ShowProduct;
