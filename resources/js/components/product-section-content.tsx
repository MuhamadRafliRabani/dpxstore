import { productContentType } from '@/types';
import NotFound from './not-found';
import ProductCard from './product-card';
import { CardContent } from './ui/card';
import Diamond from './ui/diamond';
import Image from './ui/loading-image';

export default function ProductContent({ category, products, errors, data, setData }: productContentType) {
    switch (category) {
        case 'Games': {
            const starlightProducts = products.filter((p) => p.product_name?.toLowerCase().includes('starlight'));
            const weeklyDiamondPass = products.filter((p) => p.product_name?.toLowerCase().includes('weekly diamond pass'));
            const otherProducts = products.filter(
                (p) => !p.product_name?.toLowerCase().includes('starlight') && !p.product_name?.toLowerCase().includes('weekly diamond pass'),
            );

            console.log(otherProducts);

            if (products.length == 0) {
                return (
                    <CardContent className="flex min-h-40 items-center px-1 py-0 sm:px-4">
                        <NotFound item="products" message="Mohon kembali lagi nanti atau explore product lain." />
                    </CardContent>
                );
            }

            return (
                <CardContent className="space-y-4 px-3.5 py-2">
                    {weeklyDiamondPass.length !== 0 && (
                        <div className="">
                            <div className="mb-2 flex w-full items-center gap-2">
                                <h1 className="text-accent-foreground text-sm font-semibold">Weekly Diamond Pass</h1>
                                <Image src="/storage/website/19284619.webp" className="size-6 object-cover" alt="Weekly Diamond Pass" />
                            </div>
                            <ul className="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                {weeklyDiamondPass.map((product) => (
                                    <li key={product.id}>
                                        <ProductCard
                                            title={product.product_name}
                                            price={product.price}
                                            selected={data.product_id === product.id}
                                            onClick={() => setData('product_id', product.id)}
                                            icon={<Image src="/storage/website/19284619.webp" className="size-6 object-cover object-center" alt="" />}
                                        />
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    {starlightProducts.length !== 0 && (
                        <div className="">
                            <div className="mb-2 flex w-full items-center gap-2">
                                <h1 className="text-accent-foreground text-sm font-semibold">Starlight</h1>
                                <Image src="/storage/website/19284619.webp" className="size-6 object-cover" alt="Starlight" />
                            </div>
                            <ul className="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                {starlightProducts.map((product) => (
                                    <li key={product.id}>
                                        <ProductCard
                                            title={product.product_name}
                                            price={product.price}
                                            selected={data.product_id === product.id}
                                            onClick={() => setData('product_id', product.id)}
                                            icon={<Image src="/storage/website/19284619.webp" className="size-6 object-cover object-center" alt="" />}
                                        />
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    {otherProducts.length !== 0 && (
                        <div className="">
                            <h1 className="text-accent-foreground mb-2 flex items-center gap-1 text-sm font-semibold">
                                Diamond <Diamond />
                            </h1>
                            <ul className="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                {otherProducts.map((product) => (
                                    <li key={product.id}>
                                        <ProductCard
                                            title={product.product_name}
                                            price={product.price}
                                            selected={data.product_id === product.id}
                                            onClick={() => setData('product_id', product.id)}
                                            icon={<Diamond />}
                                        />
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}
                </CardContent>
            );
        }

        case 'Data & Pulsa': {
            const internetProducts = products.filter(
                (p) => p.product_name?.toLowerCase().includes('internet') || p.product_name?.toLowerCase().includes('data'),
            );

            const otherProducts = products.filter((p) => !p.product_name?.toLowerCase().includes('internet'));

            if (products.length == 0) {
                return (
                    <CardContent className="flex min-h-40 items-center px-1 py-0 sm:px-4">
                        <NotFound item="products" message="Mohon kembali lagi nanti atau explore product lain." />
                    </CardContent>
                );
            }

            return (
                <CardContent className="px-1 py-0 sm:px-4">
                    <div className="mb-2 flex w-full items-center gap-2">
                        <h1 className="text-primary text-lg font-semibold">Data</h1>
                    </div>
                    <ul className="mb-4 grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {internetProducts.map((product) => (
                            <li key={product.id}>
                                <ProductCard
                                    title={product.product_name}
                                    price={product.price}
                                    selected={data.product_id === product.id}
                                    onClick={() => setData('product_id', product.id)}
                                    icon={null}
                                />
                            </li>
                        ))}
                        {errors.product_id && <p className="mt-1 text-sm text-red-500">{errors.product_id}</p>}
                    </ul>

                    <h1 className="text-primary mb-2 flex items-center gap-2 text-lg font-semibold">Pulsa</h1>
                    <ul className="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {otherProducts.map((product) => (
                            <li key={product.id}>
                                <ProductCard
                                    title={product.product_name}
                                    price={product.price}
                                    selected={data.product_id === product.id}
                                    onClick={() => setData('product_id', product.id)}
                                    icon={null}
                                />
                            </li>
                        ))}
                        {errors.product_id && <p className="mt-1 text-sm text-red-500">{errors.product_id}</p>}
                    </ul>
                </CardContent>
            );
        }

        case 'Voucher': {
            // const internetProducts = products.filter((p) => p.product_name?.toLowerCase().includes('internet'));
            // const otherProducts = products.filter((p) => !p.product_name?.toLowerCase().includes('internet'));

            if (products.length == 0) {
                return (
                    <CardContent className="flex min-h-70 items-center px-1 py-0 sm:px-4">
                        <NotFound item="products" message="Mohon kembali lagi nanti atau explore product lain." />
                    </CardContent>
                );
            }

            return (
                <CardContent className="px-1 py-0 sm:px-4">
                    <h1 className="text-primary mb-2 flex items-center gap-2 text-lg font-semibold">Voucher</h1>
                    <ul className="grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {products.map((product) => (
                            <li key={product.id}>
                                <ProductCard
                                    title={product.product_name}
                                    price={product.price}
                                    selected={data.product_id === product.id}
                                    onClick={() => setData('product_id', product.id)}
                                    icon={null}
                                />
                            </li>
                        ))}
                        {errors.product_id && <p className="mt-1 text-sm text-red-500">{errors.product_id}</p>}
                    </ul>
                </CardContent>
            );
        }

        default:
            return null;
    }
}
