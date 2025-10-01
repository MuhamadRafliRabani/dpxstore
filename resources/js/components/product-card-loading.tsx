const ProductCardLoading = () => {
    return (
        <div className="group bg-accent-foreground/30 border-accent relative inline-flex h-55 w-40 shrink-0 animate-pulse cursor-pointer justify-center overflow-hidden rounded-md border shadow-md hover:scale-98 hover:shadow-lg">
            <div className="bg-accent absolute right-0 bottom-0 left-0 space-y-2 p-2">
                <h3 className="bg-accent-foreground/50 h-4 animate-pulse rounded"></h3>
                <p className="bg-accent-foreground/50 h-3 animate-pulse rounded"></p>
            </div>

            <span className="absolute top-0 left-[-75%] z-10 h-full w-[50%] rotate-12 bg-white/20 blur-lg transition-all duration-1000 ease-in-out group-hover:left-[125%]" />
            <span className="drop-shadow-3xl absolute top-0 left-0 block h-[20%] w-1/2 rounded-tl-lg transition-all duration-300" />
            <span className="drop-shadow-3xl absolute top-0 right-0 block h-[60%] w-1/2 rounded-tr-lg transition-all duration-300 group-hover:h-[90%]" />
            <span className="drop-shadow-3xl absolute bottom-0 left-0 block h-[60%] w-1/2 rounded-bl-lg transition-all duration-300 group-hover:h-[90%]" />
            <span className="drop-shadow-3xl absolute right-0 bottom-0 block h-[20%] w-1/2 rounded-br-lg transition-all duration-300" />
        </div>
    );
};

export default ProductCardLoading;
