/**
 * Home Page
 *
 * Main landing page with all home sections.
 * Components are dynamically imported for better performance.
 *
 * @module app/page
 */

import dynamic from "next/dynamic";
import Hero from "@/components/Home/Hero";

// Dynamic imports for below-the-fold content
const WhatWeDo = dynamic(() => import("@/components/Home/WhatWeDo"), {
  loading: () => <div className="py-20 bg-gray-50" />,
});

const OurServices = dynamic(() => import("@/components/Home/OurServices"), {
  loading: () => <div className="py-20 bg-white" />,
});

const ProductCategories = dynamic(
  () => import("@/components/Home/ProductCategories"),
  {
    loading: () => <div className="py-20 bg-white" />,
  }
);

const InteriorDesign = dynamic(
  () => import("@/components/Home/InteriorDesign"),
  {
    loading: () => <div className="py-20 bg-gray-50" />,
  }
);

const Process = dynamic(() => import("@/components/Home/Process"), {
  loading: () => <div className="py-20 bg-white" />,
});

const WhyUs = dynamic(() => import("@/components/Home/WhyUs"), {
  loading: () => <div className="py-20 bg-gray-50" />,
});

const Partners = dynamic(() => import("@/components/Home/Partners"), {
  loading: () => <div className="py-20 bg-white" />,
});

const FinalCta = dynamic(() => import("@/components/Home/FinalCta"), {
  loading: () => <div className="py-20 bg-primary/5" />,
});

export default function Home() {
  return (
    <>
      <Hero />
      <WhatWeDo />
      <OurServices />
      <ProductCategories />
      <InteriorDesign />
      <Process />
      <WhyUs />
      <Partners />
      <FinalCta />
    </>
  );
}
