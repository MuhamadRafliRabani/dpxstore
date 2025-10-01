import FilterProduct from '@/components/filter-product';
import PopularSection from '@/components/popular-section';
import Products from '@/components/Products';
import AppLayout from '@/layouts/app-layout';

const HomePage = () => {
    return (
        <AppLayout>
            <div className="w-full overflow-hidden">
                <section className="bg-popover overflow-hidden">
                    {/* Section Populer */}
                    <PopularSection />

                    {/* Section Filter Product */}
                    <FilterProduct />

                    {/* Section Product */}
                    <Products />
                </section>
            </div>
        </AppLayout>
    );
};

export default HomePage;
