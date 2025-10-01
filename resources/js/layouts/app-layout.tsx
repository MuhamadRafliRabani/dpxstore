import Carousell from '@/components/carousell';
import Footer from '@/components/footer';
import Navbar from '@/components/navbar';
import { replaceAppName } from '@/lib/replace-text';
import { categoriesType, configuration } from '@/types';
import { Head, usePage } from '@inertiajs/react';

type props = { title: string; description: string; categories: categoriesType; configuration: configuration };

export default function AppLayout({ children }: { children: React.ReactNode }) {
    const { title, description, categories, configuration } = usePage<props>().props;

    return (
        <div className="bg-popover flex min-h-screen min-w-screen flex-col overflow-hidden">
            <Head>
                <title>{title}</title>
                <meta name="description" content={replaceAppName(description, configuration.website)} />
            </Head>

            <Navbar />

            <main className="overflow-hidden">
                {categories ? <Carousell /> : null}
                <section style={{ backfaceVisibility: 'hidden' }} className="container mx-auto flex-1 py-6">
                    {children}
                </section>
            </main>

            <Footer />
        </div>
    );
}
