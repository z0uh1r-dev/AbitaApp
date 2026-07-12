/**
 * Section Header Component
 *
 * Reusable header for sections with title and description.
 * Used across multiple pages for consistent styling.
 *
 * @module UI/SectionHeader
 */

import { memo } from "react";

interface SectionHeaderProps {
  title: string;
  description: string;
}

function SectionHeader({ title, description }: SectionHeaderProps) {
  return (
    <div className="text-center mb-16">
      <h2 className="text-4xl md:text-5xl font-bold mb-4">{title}</h2>
      <p className="text-xl text-gray-600 max-w-2xl mx-auto">{description}</p>
    </div>
  );
}

export default memo(SectionHeader);
