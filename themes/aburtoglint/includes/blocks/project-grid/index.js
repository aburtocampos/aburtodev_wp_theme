import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl, SelectControl } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

registerBlockType('glint/project-grid', {
  edit({ attributes, setAttributes }) {
    const { itemsToShow, postType, category, linkTitle, linkImage } = attributes;

    const [posts, setPosts] = useState([]);
    const [categories, setCategories] = useState([]);
    const [postTypes, setPostTypes] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);

    // Load post types (filtered)
    useEffect(() => {
      apiFetch({ path: '/wp/v2/types' }).then((types) => {
        const filtered = Object.entries(types)
          .filter(([slug, type]) =>
            type.viewable &&
            !slug.startsWith('wp_') &&
            slug !== 'attachment' &&
            type.hierarchical === false
          )
          .map(([slug, type]) => ({
            label: type.name,
            value: slug,
          }));
        setPostTypes(filtered);
      });
    }, []);

    // Fetch posts with pagination for preview
    useEffect(() => {
      if (!postType) return;
      apiFetch({ path: `/wp/v2/${postType}?per_page=${itemsToShow}&page=${currentPage}&_embed` })
        .then(setPosts)
        .catch(() => setPosts([]));
    }, [itemsToShow, postType, currentPage]);

    // Load categories based on post type
    useEffect(() => {
      if (!postType) return;
      apiFetch({ path: `/wp/v2/${postType}_category?per_page=100` })
        .then(setCategories)
        .catch(() => setCategories([]));
    }, [postType]);

    const blockProps = useBlockProps({ className: 'project-grid-editor-preview' });

    return (
      <>
        <InspectorControls>
          <PanelBody title="Project Grid Settings" initialOpen={true}>
            <TextControl
              label="Items to show"
              type="number"
              value={itemsToShow}
              min={1}
              onChange={(val) => setAttributes({ itemsToShow: parseInt(val) || 1 })}
            />

            <SelectControl
              label="Post Type"
              value={postType}
              options={postTypes.length ? postTypes : [{ label: 'Loading...', value: '' }]}
              onChange={(val) => setAttributes({ postType: val, category: '' })}
            />

            <SelectControl
              label="Filter by Category"
              value={category}
              options={[
                { label: 'All', value: '' },
                ...categories.map((cat) => ({
                  label: cat.name,
                  value: String(cat.id),
                })),
              ]}
              onChange={(val) => setAttributes({ category: val })}
            />

            <ToggleControl
              label="Link Title"
              checked={linkTitle}
              onChange={(val) => setAttributes({ linkTitle: val })}
            />

            <ToggleControl
              label="Link Image"
              checked={linkImage}
              onChange={(val) => setAttributes({ linkImage: val })}
            />
          </PanelBody>
        </InspectorControls>

        <div {...blockProps} tabIndex={0}>
          {posts.length ? (
            <>
              {posts.map((post) => {
                const featuredMedia = post._embedded?.['wp:featuredmedia']?.[0];
                const imgUrl = featuredMedia?.source_url || '';
                const linkUrl = post.link || '#';

                return (
                  <div key={post.id} className="preview-item">
                    {imgUrl && linkImage ? (
                      <a href={linkUrl} target="_blank" rel="noopener noreferrer">
                        <img src={imgUrl} alt={post.title?.rendered} style={{ width: '100%', height: 'auto' }} />
                      </a>
                    ) : imgUrl ? (
                      <img src={imgUrl} alt={post.title?.rendered} style={{ width: '100%', height: 'auto' }} />
                    ) : null}

                    {linkTitle ? (
                      <h4>
                        <a href={linkUrl} target="_blank" rel="noopener noreferrer">
                          {post.title?.rendered}
                        </a>
                      </h4>
                    ) : (
                      <h4>{post.title?.rendered}</h4>
                    )}

                    {post.excerpt?.rendered && (
                      <div dangerouslySetInnerHTML={{ __html: post.excerpt.rendered }} />
                    )}
                  </div>
                );
              })}
              <div className="pagination-controls">
                {currentPage > 1 && (
                  <button onClick={() => setCurrentPage(currentPage - 1)}>Anterior</button>
                )}
                {posts.length === itemsToShow && (
                  <button onClick={() => setCurrentPage(currentPage + 1)}>Siguiente</button>
                )}
              </div>
            </>
          ) : (
            <p>No items found for preview.</p>
          )}
        </div>
      </>
    );
  },

  save() {
    return null; // Rendered via PHP
  },
});

